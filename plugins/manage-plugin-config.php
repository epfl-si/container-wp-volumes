<?PHP
/*
   GOAL: Allow to extract (by comparison) a WordPress plugin configuration so it can be used
         to configure the plugin after a "fresh" WordPress install.

   VERSION : 0.1
      - Working version (not flexible)
      - Minimum comments
      - "Dirty code"
*/


   ini_set('display_errors', 1);
   error_reporting(E_ALL^ E_NOTICE);

/*
   Exec with: docker exec wordpress sh -c "php /var/www/html/wp-content/plugins/manage-plugin-config.php <step_no> <plugin_name>"


   1. Connect on WordPress admin panel
   2. Activate plugin
   3. Go on all links on the left menu
   4. Go on all plugin configuration page
   5. Execute STEP 1 of this script
   6. Configure plugin AND stay on configuration page !
   7. Execute STEP 2 of this script to extract and save plugin configuration
*/

   
   /* To access DB */
   define('MYSQL_ROOT_USER',     'root');
   define('MYSQL_ROOT_PASSWORD', 'passw0rd!');
   define('WORDPRESS_HOST',      'db:3306');
   define('WORDPRESS_DB',        'wordpress');

   /* Base filenames to store configuration */
   define('PLUGIN_CONFIG_FILE_BASE', dirname(__FILE__).DIRECTORY_SEPARATOR.'_config_base-%s.serial');
   define('PLUGIN_CONFIG_FILE_FINAL', dirname(__FILE__).DIRECTORY_SEPARATOR.'_config-%s.serial');



   /* Tables in which configuration is stored. Those tables must be sorted to satisfy foreign keys*/
   $tables = array('wp_options'  => 'option_id',
                   'wp_terms'    => 'term_id',
                   'wp_termmeta' => 'meta_id', // include wp_terms.term_id
                   'wp_term_taxonomy' => 'term_taxonomy_id', // include wp_terms.term_id
                   'wp_term_relationships' => 'object_id'); // include wp_term_taxonomy.term_taxonomy_id


   /**************************** FUNCTIONS ********************************/

   function displayUsage()
   {
      global $argv;
      echo "USAGE : php ".$argv[0]." <step_no> <plugin_name>\n";
      echo "\tstep_no : 1|2|3\n";
      echo "\t\t1 = Get WP config before plugin configuration\n";
      echo "\t\t2 = Get WP diff config after plugin configuration\n";
      echo "\t\t3 = Load diff config in WP after fresh install\n";
      echo "\n";
   }
   
   /* ----------------------------------------------------------------------- */

   function getMaxIDs($for_tables)
   {
      $max_ids = array();

      $link = mysqli_connect(WORDPRESS_HOST, 
                             MYSQL_ROOT_USER, 
      	                    MYSQL_ROOT_PASSWORD,  
      	                    WORDPRESS_DB);

      if(mysqli_connect_errno() != 0) 
      {
         trigger_error(__FUNCTION__.": ".mysqli_connect_error()."\n", E_USER_ERROR);

      }

      /* Going throught tables */
      foreach($for_tables as $table_name => $id_field)
      {

         $request = "SELECT MAX($id_field) AS 'max' FROM $table_name";  
         
         if(($res = mysqli_query($link, $request))===false)
         {
            trigger_error(__FUNCTION__.": ".mysqli_error($link)."\n", E_USER_ERROR);
         }
         
         $res = mysqli_fetch_assoc($res);
         
         $max_ids[$table_name] = ($res['max']=="")?0:$res['max'];
      }

      
      mysqli_close($link);
      
      return $max_ids;
   
   }

   /* ----------------------------------------------------------------------- */

   function extractConfigDiff($for_tables, $base_config)
   {
      $config_diff = array();      

      $link = mysqli_connect(WORDPRESS_HOST, 
                             MYSQL_ROOT_USER, 
      	                    MYSQL_ROOT_PASSWORD,  
      	                    WORDPRESS_DB);

      if(mysqli_connect_errno() != 0) 
      {
         trigger_error(__FUNCTION__.": ".mysqli_connect_error()."\n", E_USER_ERROR);

      }

      /* Going throught tables */
      foreach($for_tables as $table_name => $id_field)
      {
         /* Get diff for table */
         $request = "SELECT * FROM $table_name WHERE $id_field > $base_config[$table_name]";

         if(($res = mysqli_query($link, $request))===false)
         {
            trigger_error(__FUNCTION__.": ".mysqli_error($link)."\n", E_USER_ERROR);
         }

         $config_diff[$table_name] = array();

         /* Going through result and store in array */
         while($row = mysqli_fetch_assoc($res))
         {
            $config_diff[$table_name][] = $row;
         }

      }

      mysqli_close($link);

      return $config_diff;

   }

   /* ----------------------------------------------------------------------- */

   function loadConfig($for_tables, $diff_config)
   {
      $link = mysqli_connect(WORDPRESS_HOST, 
                             MYSQL_ROOT_USER, 
      	                    MYSQL_ROOT_PASSWORD,  
      	                    WORDPRESS_DB);

      if(mysqli_connect_errno() != 0) 
      {
         trigger_error(__FUNCTION__.": ".mysqli_connect_error()."\n", E_USER_ERROR);

      }

//print_r($diff_config);exit;

      /* Going throught tables */
      foreach($for_tables as $table_name => $id_field)
      {


         /* Going through rows to add in table */
         foreach($diff_config[$table_name] as $row)
         {

            $request = "INSERT IGNORE INTO $table_name (".implode(",",array_keys($row)).") VALUES('".implode("','",array_map('addslashes', $row))."')";

            if(($res = mysqli_query($link, $request))===false)
            {
               trigger_error(__FUNCTION__.": ".mysqli_error($link)."\n", E_USER_ERROR);
            }
         }
      }

      mysqli_close($link);
   }


   /**************************** MAIN PROGRAM *********************************/

   /* Check if all arguments are here */
   if(sizeof($argv)<3)
   {
      displayUsage();
      exit;
   }

   /* Getting parameters */
   $step_no = $argv[1];
   $plugin_name = $argv[2];



   switch($step_no)
   {
      /** Step 1 : Get "base" configuration in tables **/
      case 1:
      {
         echo "Getting settings before configuration of plugin $plugin_name... ";

         $config = getMaxIDs($tables);

         print_r($config);

         $base_config_file = sprintf(PLUGIN_CONFIG_FILE_BASE, $plugin_name);

         $handle = fopen($base_config_file, 'w+');
         fwrite($handle, serialize($config));
         fclose($handle);

         echo "done (base information saved in '$base_config_file')\n\n";
         echo "You can now configure the plugin '$plugin_name' in WordPress and then re-execute this script with the following command line:\n";
         echo "php ".__FILE__." 2 \"$plugin_name\"\n";
         break;
      }

      /** Step 2 : Compare "base" configuration with new configuration after plugin configuration **/
      case 2: 
      {
         $substep=0;
         echo "Getting configuration for plugin $plugin_name...\n";
         
         /* --- */
         $substep++;echo " [$substep] Loading base configuration... ";
         $base_config_file = sprintf(PLUGIN_CONFIG_FILE_BASE, $plugin_name);
         $base_config = unserialize(file_get_contents($base_config_file));
         echo "done\n";
         
         /* --- */
         $substep++;echo " [$substep] Extracting configuration differences... ";
         $diff_config = extractConfigDiff($tables, $base_config);
         echo "done\n";

         print_r($diff_config);
         
         /* --- */
         $diff_config_file = sprintf(PLUGIN_CONFIG_FILE_FINAL, $plugin_name);
         $substep++;echo " [$substep] Saving configuration to file ($diff_config_file)... ";

         $handle = fopen($diff_config_file, 'w+');
         fwrite($handle, serialize($diff_config));
         fclose($handle);



         break;
      }

      /** Step 3 : Load configuration for plugin and save it in DB **/
      case 3 :
      {
         $substep=0;
         echo "Loading configuration for plugin $plugin_name...\n";

         /* --- */
         $substep++;echo " [$substep] Loading diff configuration... ";
         $diff_config_file = sprintf(PLUGIN_CONFIG_FILE_FINAL, $plugin_name);
         $diff_config = unserialize(file_get_contents($diff_config_file));
         echo "done\n";

         /* --- */
         $substep++;echo " [$substep] Updating plugin configuration in DB... ";
         loadConfig($tables, $diff_config);
         echo "done\n";         


         break;
      }

   }
   

   

   


?>

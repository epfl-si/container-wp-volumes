<?PHP
/*
   GOAL: Allow to extract (by comparison) a WordPress plugin configuration so it can be used
         to configure the plugin after a "fresh" WordPress install.

   HISTORY : 
   0.1
      - Working version (not flexible)
      - Minimum comments
      - "Dirty code"
      
   0.2
      - More comments
      - Use input parameters
      - Simplify DB connection code   
      
   0.3
      - Now use a class to do things

   -------------------------------------------------------------------------------------------
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




   /****************************** CLASS **********************************/
   
   
   class PluginConfig
   {
      var $plugin_name;
      var $db_link;
      var $config_tables;
   
      
      /*
         GOAL : Class contructor
         
         $plugin_name   : Plugin name for which we want to manage the configuration
      */     
      function PluginConfig($plugin_name)
      {
         $this->plugin_name = $plugin_name;
         $this->base_config = array();
         /* Tables in which configuration is stored. Those tables must be sorted to satisfy foreign keys*/
         $this->config_tables = array('wp_options'              => 'option_id',
                                      'wp_terms'                => 'term_id',
                                      'wp_termmeta'             => 'meta_id', // include wp_terms.term_id
                                      'wp_term_taxonomy'        => 'term_taxonomy_id', // include wp_terms.term_id
                                      'wp_term_relationships'   => 'object_id'); // include wp_term_taxonomy.term_taxonomy_id
         
         /* Open DB connection */
         $this->db_link = mysqli_connect(WORDPRESS_HOST, MYSQL_ROOT_USER, MYSQL_ROOT_PASSWORD, WORDPRESS_DB);

         if(mysqli_connect_errno() != 0) 
         {
            trigger_error(__CLASS_.":".__FUNCTION__.": ".mysqli_connect_error()."\n", E_USER_ERROR);

         }
      }
      
      /* ----------------------------------------------------------------------- */
      
      
      /*
         GOAL : Return the filename to use to store base configuration.
      */
      protected function getBaseConfigFilename()
      {
         return sprintf(PLUGIN_CONFIG_FILE_BASE, $this->plugin_name);
      }
      
      
      /*
         GOAL : Return the filename to use to store plugin configuration.
      */
      protected function getPluginConfigFilename()
      {
         return sprintf(PLUGIN_CONFIG_FILE_FINAL, $this->plugin_name);
      }
      
      /* ----------------------------------------------------------------------- */
      
      /*
         GOAL  : Take a "snapshot" of configuration tables before plugin configuration.
                 In fact, we get max ID for each tables in which configuration is stored.
                 
                 The information are saved in a file
      */
      function extractAndSaveConfigSnapshot()
      {
      
         $base_config = array();
         
         /* Going throught tables */
         foreach($this->config_tables as $table_name => $id_field)
         {

            $request = "SELECT MAX($id_field) AS 'max' FROM $table_name";  
            
            if(($res = mysqli_query($this->db_link, $request))===false)
            {
               trigger_error(__FUNCTION__.": ".mysqli_error($this->db_link)."\n", E_USER_ERROR);
            }
            
            $res = mysqli_fetch_assoc($res);

            /* Determining max ID */         
            $base_config[$table_name] = ($res['max']=="")?0:$res['max'];

         }/* END LOOP Going through tables */      
         
         /* Generate output filename */
         $base_config_file = $this->getBaseConfigFilename();

         $handle = fopen($base_config_file, 'w+');
         fwrite($handle, serialize($base_config));
         fclose($handle);
         
         $this->closeDBConnection();
      
      }
      
      /* ----------------------------------------------------------------------- */
      
      /*
         GOAL : Use the base configuration saved before to determine which rows have been
                added in the DB during plugin configuration.
                
                The difference contains the plugin configuration. We save it in a file.
      */
      function extractAndSavePluginConfig()
      {
         $config_diff = array();
         
         /* Generate filename and load base configuration  */
         $base_config_file = $this->getBaseConfigFilename();
         $base_config = unserialize(file_get_contents($base_config_file));         
         
         /* Going throught tables */
         foreach($this->config_tables as $table_name => $id_field)
         {
            /* Get diff for table */
            $request = "SELECT * FROM $table_name WHERE $id_field > $base_config[$table_name]";

            if(($res = mysqli_query($this->db_link, $request))===false)
            {
               trigger_error(__FUNCTION__.": ".mysqli_error($this->db_link)."\n", E_USER_ERROR);
            }
            
            /* To store configuration */
            $config_diff[$table_name] = array();

            /* Going through result and store in array */
            while($row = mysqli_fetch_assoc($res))
            {
               $config_diff[$table_name][] = $row;
            }

         }/* END LOOP Going through tables */   
         
         print_r($config_diff);
         
          $diff_config_file = $this->getPluginConfigFilename();

          
          /* Save configuration in file */
          $handle = fopen($diff_config_file, 'w+');
          fwrite($handle, serialize($config_diff));
          fclose($handle);
          
          $this->closeDBConnection();
      }


      /* ----------------------------------------------------------------------- */
      
      
      /*
         GOAL : Load the plugin configuration stored in the file and update WP database
      */      
      function importPluginConfig()
      {
         $diff_config_file = $this->getPluginConfigFilename();
         $diff_config = unserialize(file_get_contents($diff_config_file));
         
         /* Going throught tables */
         foreach($this->config_tables as $table_name => $id_field)
         {

            /* Going through rows to add in table */
            foreach($diff_config[$table_name] as $row)
            {

               $request = "INSERT IGNORE INTO $table_name (".implode(",",array_keys($row)).") VALUES('".implode("','",array_map('addslashes', $row))."')";

               if(($res = mysqli_query($this->db_link, $request))===false)
               {
                  trigger_error(__FUNCTION__.": ".mysqli_error($this->db_link)."\n", E_USER_ERROR);
               }
            } /* END LOOP Going through table rows */
         
         }/* END LOOP Going through tables */
         
         $this->closeDBConnection();
      }
      
      
      /* ----------------------------------------------------------------------- */
      
      /*
         GOAL : Close DB connection
      */
      function closeDBConnection()
      {
         mysqli_close($this->db_link);
      }
      
   }


   /**************************** FUNCTIONS ********************************/


   /*
      GOAL : Display how to use this script
   */
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

   /* Object creation */
   $pc = new PluginConfig($plugin_name);



   switch($step_no)
   {
      /** Step 1 : Get "base" configuration in tables **/
      case 1:
      {
         echo "Getting settings before configuration of plugin $plugin_name... ";

         $pc->extractAndSaveConfigSnapshot();
         echo "done\n";
         break;
      }

      /** Step 2 : Compare "base" configuration with new configuration after plugin configuration **/
      case 2: 
      {

         echo "Getting configuration for plugin $plugin_name... ";
         
         $pc->extractAndSavePluginConfig();         
            
         echo "done\n";



         break;
      }

      /** Step 3 : Load configuration for plugin and save it in DB **/
      case 3 :
      {
         $substep=0;
         echo "Importing configuration for plugin $plugin_name... ";

         $pc->importPluginConfig();
         
         echo "done\n";         


         break;
      }


   }
   

   

   


?>

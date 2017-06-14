<?PHP
/*
   GOAL: 
   =====
   Allow to extract (by comparison) a WordPress plugin configuration so it can be used
   to configure the plugin after a "fresh" WordPress install.



   README:
   =======
   This script needs to be saved in '../master-wp/container-wp-volumes/plugins/' folder.
      
   Execution can be done with: 
   docker exec wordpress sh -c "php /var/www/html/wp-content/plugins/manage-plugin-config.php <step_no> <plugin_name>"

   
   USE IN DOCKER DEPLOYMENT:
   =========================
   Modify the file '../master-wp/Makefile" in section "install" to add lines like the following:
   docker exec wordpress sh -c "php /var/www/html/wp-content/plugins/manage-plugin-config.php 3 <plugin_name>"
   
   But to execute correctly, the 'config' file for the plugin you want to configure has to exists.

   
   HOW TO USE THIS SCRIPT:
   =======================
   0. Deploy WordPress instance with docker
   1. Connect on WordPress admin panel
   2. Activate plugin 
   3. Go on all links on the left menu
   4. Go on all plugin configuration page
   5. Execute STEP 1 of this script
      $ docker exec wordpress sh -c "php /var/www/html/wp-content/plugins/manage-plugin-config.php 1 <plugin_name>"
   6. Configure plugin AND stay on configuration page !
   7. Execute STEP 2 of this script to extract and save plugin configuration
      $ docker exec wordpress sh -c "php /var/www/html/wp-content/plugins/manage-plugin-config.php 2 <plugin_name>"
   8. Reinstall WordPress from scratch
   9. Execute STEP 3 of this script to import plugin configuration. (have a look at 'Use in docker deployment')
      $ docker exec wordpress sh -c "php /var/www/html/wp-content/plugins/manage-plugin-config.php 3 <plugin_name>"





   HISTORY : 
   =========
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
      - Add "unique" key information for option tables
      - Add new option table (wp_postmeta)
      - Add information about table relation (not real foreign keys but exists) to be able to map correctly 
        the information we add between them (keep the mapping and avoid conflicts)
      - Handle foreign values already existing in DB (not present in the configuration save file)
      - Handle rows that are deleted and recreated with another ID (bigger) by the plugin. Duplicate entry 
        error is handled and existing row id is recovered
   
   0.4
      - Handle plugin that store "empty" configuration in DB before user do the manual configuration. 
        If configuration already exists, it is updated and the mapping with the existing is kept.
      - Check if config files exists before opening them.
        + Error will be thrown if 'base config' file doesn't exists
        + Import plugin configuration will be ignored if config file doesn't exists. 
        
   0.5
      - Config files have been moved in a dedicated directory (defined by CONFIG_FOLDER). If the
        directory doesn't exists, it is created.
      - Change created config files base names. The plugin name is now at the beginning of the file.
      - Information to access WP database are not hard-coded anymore. They are now directly retrieved
        in WordPress configuration file (wp-config.php). The recovered information are :
        DB_NAME
        DB_HOST
        DB_USER
        DB_PASSWORD
        DB_CHARSET (not handled before)
        $table_prefix (not handled before)
      - WordPress tables name are now prefixed with the prefix defined in 'wp-config.php'
      - Some code cleaning
      - Single point to trigger errors
      
     
   TODO :
   - Add error check (find what)
   - 

   -------------------------------------------------------------------------------------------
*/


   ini_set('display_errors', 1);
   error_reporting(E_ALL^ E_NOTICE);



   /* Path to WordPress config file */
   define('WP_CONFIG_FILE',   '/var/www/html/wp-config.php');

   /* To store configuration files in another folder */
   define('CONFIG_FOLDER',   '_plugin-config');


   /* Folder where to store config files */
   define('PLUGIN_CONFIG_FOLDER_PATH',   dirname(__FILE__).DIRECTORY_SEPARATOR.CONFIG_FOLDER.DIRECTORY_SEPARATOR);
   
   /* Base filenames to store configuration */
   define('PLUGIN_CONFIG_FILE_REF', '%s-reference.serial');
   define('PLUGIN_CONFIG_FILE_FINAL', '%s-config.serial');



   /****************************** CLASS **********************************/
   
   
   class PluginConfig
   {
      var $plugin_name;       /* Save plugin name */
      var $db_link;           /* Link to the DB */
      var $config_tables;     /* Configuration about table (auto-gen fields, unique fields) */
      var $tables_relations;  /* Information about "non-official" links/relations between tables */
   
      
      /*
         GOAL : Class contructor
         
         $plugin_name   : Plugin name for which we want to manage the configuration
      */     
      function PluginConfig($plugin_name)
      {
         $this->plugin_name = $plugin_name;
         
 
                                         
         
         
         /**** CONGIF FILES LOCATION ****/
         
         /* If directory to store config files doesn't exists, we create it */
         if(!file_exists(PLUGIN_CONFIG_FOLDER_PATH))
         {
            mkdir(PLUGIN_CONFIG_FOLDER_PATH, 0777);
         }

         
         /**** Get WordPress DATABASE configuration in the wp-config.php file. ****/
         /* To do this, we will :
            1. Read WordPress "wp-config.php" file
            2. Extract the code defining the DB access configuration
            3. Do an 'eval()' on the extracted code to have constants defined in this script */
            
         $define_to_find = array('DB_NAME', 'DB_USER', 'DB_PASSWORD', 'DB_HOST', 'DB_CHARSET');
         
         /* Base RegEx to look for 'define' */      
         $base_wp_param_reg = '/define\([\s]*\'%s\'[\s]*,[\s]*\'[\S]+\'\);/i';
   
         /* Getting 'wp-config.php' file content */
         $config = file_get_contents(WP_CONFIG_FILE);
               
         /* Going through 'define' to recover */
         foreach($define_to_find as $define_name)
         {
            $matches = array();
            
            /* Generate RegEx for current 'define' */
            $define_reg = sprintf($base_wp_param_reg, $define_name);

            /* Searching information */
            preg_match($define_reg, $config, $matches);
            

            /* Defining constant for current script */
            eval($matches[0]);
         }
         
         
         /* Searching for DB table prefix. The line looks like :
            $table_prefix = 'wp_';
         */
         preg_match('/\$table_prefix[\s]*=[\s]*\'[\S]+\';/i', $config, $matches);
         
         eval($matches[0]);
         
         
         /**** DB Connection ****/
         /* Open DB connection with previously recovered information */
         $this->db_link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

         if(mysqli_connect_errno() != 0) 
         {
            trigger_error(__FILE__.":".__FUNCTION__.": ".mysqli_connect_error()."\n", E_USER_ERROR);

         }
         
         /* Init database charset */
         mysqli_set_charset($this->db_link, DB_CHARSET);
         
         
         
         
         
        
         /**** WORDPRESS TABLES DESCRIPTION ****/
         
         /* Tables in which configuration is stored, with 'auto gen id' fields and 'unique field' (others than only auto-gen field). Those tables must be sorted to satisfy foreign keys*/
         $this->config_tables = array($table_prefix.'postmeta'             => array('meta_id', null),
                                      $table_prefix.'options'              => array('option_id', 'option_name'),
                                      $table_prefix.'terms'                => array('term_id', null),
                                      $table_prefix.'termmeta'             => array('meta_id', null), // include wp_terms.term_id
                                      $table_prefix.'term_taxonomy'        => array('term_taxonomy_id', null), // include wp_terms.term_id
                                      $table_prefix.'term_relationships'   => array(null, array('object_id', 'term_taxonomy_id'))); // include wp_term_taxonomy.term_taxonomy_id
         
         /* Relation between configuration tables. There are no explicit relation between tables in DB but there are relation coded in WP. */                             
         $this->tables_relations = array($table_prefix.'termmeta'            => array('term_id'          => $table_prefix.'terms'),
                                         $table_prefix.'term_taxonomy'       => array('term_id'          => $table_prefix.'terms'),
                                         $table_prefix.'term_relationships'  => array('term_taxonomy_id' => $table_prefix.'term_taxonomy'));         
         
      }
      
      /* ----------------------------------------------------------------------- */
      /*                           PROTECTED FUNCTIONS                           */
      /* ----------------------------------------------------------------------- */
      
      
      /*
         GOAL : Return the filename to use to store base configuration.
      */
      protected function getReferenceConfigFilename()
      {
         return sprintf(PLUGIN_CONFIG_FOLDER_PATH.PLUGIN_CONFIG_FILE_REF, $this->plugin_name);
      }
      
      /* ----------------------------------------------------------------------- */
      
      /*
         GOAL : Return the filename to use to store plugin configuration.
      */
      protected function getPluginConfigFilename()
      {
         return sprintf(PLUGIN_CONFIG_FOLDER_PATH.PLUGIN_CONFIG_FILE_FINAL, $this->plugin_name);
      }
      
      
      /* ----------------------------------------------------------------------- */
      
      
      /*
         GOAL : Return information about foreign key information if exists
         
         $for_src_table    : Source table for which we have to check for a foreign key
         $for_src_fiedl    : Field in the source table for which we have to check for a foreign key
         
         RET : NULL -> no foreign key
               Target table name
      */
      protected function getForeignKeyTable($for_src_table, $for_src_field)
      {

         /* If there is foreign key information for the table, */
         if(array_key_exists($for_src_table, $this->tables_relations))
         {
            /* If there is a foreign key defined for the field, */
            if(array_key_exists($for_src_field, $this->tables_relations[$for_src_table]))
            {
               /* We return the exploded string <table>.<field> as result */
               return $this->tables_relations[$for_src_table][$for_src_field];
            }
         
         }/* END IF there is foreign key information for table */
         
         /* If we reach this point, it means no information was found. */
         return null;
      }
      
      /* ----------------------------------------------------------------------- */
      
      
      /*
         GOAL : Triggers an error. This function exists to have a single point to 
                trigger error with the right information displayed
                
         $function      : name of the function where the error was triggered
         $error_string  : Error message
      */
      protected function triggerError($function, $error_string)
      {
         trigger_error(__FILE__.":".$function.": ".$error_string."\n", E_USER_ERROR);
      }
      
      
      /* ----------------------------------------------------------------------- */
      /*                           PUBLIC FUNCTIONS                              */
      /* ----------------------------------------------------------------------- */
      
      /*
         GOAL  : We get max ID for each tables in which configuration is stored so we
                 will be able to know what changed when we manually did the plugin
                 configuration.
                 
                 The information are saved in a file
      */
      function extractAndSaveConfigReference()
      {
      
         $base_config = array();
         
         /* Going throught tables */
         foreach($this->config_tables as $table_name => $fields_infos)
         {
            /* Extract infos */
            list($auto_inc_field, $unique_fields) = $fields_infos;
      
            /* if no "auto-inc" field, we skip because we don't need a comparison snap */
            if($auto_inc_field === null) continue;

            $request = "SELECT MAX($auto_inc_field) AS 'max' FROM $table_name";  
            
            if(($res = mysqli_query($this->db_link, $request))===false)
            {
               $this->triggerError(__FUNCTION__, mysqli_error($this->db_link));
            }
            
            $res = mysqli_fetch_assoc($res);

            /* Determining max ID */         
            $base_config[$table_name] = ($res['max']=="")?0:$res['max'];

         }/* END LOOP Going through tables */      
         
         /* Generate output filename */
         $base_config_file = $this->getReferenceConfigFilename();

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
         $base_config_file = $this->getReferenceConfigFilename();
         
         /* If base config file doesn't exists, we skip */
         if(!file_exists($base_config_file))
         {
            $this->triggerError(__FUNCTION__,"Reference config doesn't exists for plugin '".$this->plugin_name);  
         }
         
         $base_config = unserialize(file_get_contents($base_config_file));         
         
         /* Going throught tables */
         foreach($this->config_tables as $table_name => $fields_infos)
         {
            /* Extract infos */
            list($auto_inc_field, $unique_fields) = $fields_infos;
            
            /* Get diff for table */
            $request = "SELECT * FROM $table_name";
            /* If there's an "auto-gen" field */
            if($auto_inc_field!==null) $request.= " WHERE $auto_inc_field > $base_config[$table_name]";
            
            if(($res = mysqli_query($this->db_link, $request))===false)
            {
               $this->triggerError(__FUNCTION__, mysqli_error($this->db_link));
            }
            
            /* To store configuration */
            $config_diff[$table_name] = array();

            /* Going through result and store in array */
            while($row = mysqli_fetch_assoc($res))
            {
               $config_diff[$table_name][] = $row;
            }

         }/* END LOOP Going through tables */   
         
         //print_r($config_diff);
         
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
         
         /* If config file doesn't exists, we skip */
         if(!file_exists($diff_config_file))
         {
            echo "Config file doesn't exists for plugin '".$this->plugin_name."'. Skipping.\n";
            return;
         }
         
         $diff_config = unserialize(file_get_contents($diff_config_file));
         
         /* To store ID mapping between configuration stored in files and what is inserted in DB */
         $table_id_mapping = array();
         
         /* To tell if we execute this function in "simulation" mode (meaning that we create a transaction that we rollback right after)*/
         $simulation=false;
         
         /* Start transaction if we are in "simulation" mode */
         if($simulation)mysqli_autocommit($this->db_link, false);
         
         /* Going throught tables */
         foreach($this->config_tables as $table_name => $fields_infos)
         {
         
            /* Extract infos */
            list($auto_inc_field, $unique_fields) = $fields_infos;

            /* Array transform if needed */
            if(!is_array($unique_fields)) $unique_fields = array($unique_fields);

            /* Creating mapping array for current table */
            $table_id_mapping[$table_name] = array();

            /* Going through rows to add in table */
            foreach($diff_config[$table_name] as $row)
            {
               /* Values that will be used if we can do an insert */
               $insert_values = array();
               
               /* Values that will be used if row is already existing. This means we have to update it */
               $update_values = array();
               
               /* Goint through fields/values in the row */
               foreach($row as $field => $value)
               {

                  /* If current field contains an "auto-generated id", */
                  if($auto_inc_field==$field)
                  {
                     /* Empty value so it will be generated automatically */
                     $current_value = '';
                  }
                  /* If we have information about foreign key, */
                  else if(($target_table = $this->getForeignKeyTable($table_name, $field))!==null)
                  { 
                     /* If we have a mapping for the current value, */
                     if(array_key_exists($value, $table_id_mapping[$target_table]))
                     {
                        /* Getting mapped id for current value */
                        $current_value = $table_id_mapping[$target_table][$value];
                        
                     }
                     else /* We don't have any mapping */
                     {
                        /* We take the value as it is because it is probably referencing something already existing in the DB 
                           (and not present in the saved configuration for the plugin) */
                        $current_value = $value;
                        
                     }
                  }
                  else /* We can take the value present in the config file (with 'addslashes' to be sure) */
                  {
                     $current_value = addslashes($value);
                  }
                  
                  /* We store the value to insert */
                  $insert_values[] = $current_value;
                  
                  /* If the field is NOT an "auto-generated" and NOT a part of the primary key, */
                  if($auto_inc_field!=$field && !in_array($field, $unique_fields))
                  {
                     /* We store what we need to update the row if it already exists */
                     $update_values[] = $field."='".$current_value."'";
                  }
                  
                  
               }/* END LOOPING through fields/values in the row*/
            
            
               /* Creating request to insert row or to update it if already exists */
               $request = "INSERT INTO $table_name VALUES('".implode("','", $insert_values)."') ".
                          " ON DUPLICATE KEY UPDATE ".implode(",", $update_values);

               
               if(($res = mysqli_query($this->db_link, $request))===false)
               {
                  $this->triggerError(__FUNCTION__, mysqli_error($this->db_link));
               }
               
               /* Getting ID of inserted value */
               $insert_id = mysqli_insert_id($this->db_link);
               
               
               
               /* If row wasn't inserted because already exists, (so it means we must have an 'auto-gen' field) */
               if($insert_id==0 && $auto_inc_field !== null)
               {
                  /* To store search conditions to find the existing row ID */
                  $search_conditions = array();
                  
                  /* Going through unique fields */
                  foreach($unique_fields as $unique_field_name)
                  {
                     $search_conditions[] = $unique_field_name."='".$row[$unique_field_name]."'";
                  }
                  
                  /* Creating request to search existing row information */               
                  $request = "SELECT * FROM $table_name WHERE ".implode(" AND ", $search_conditions);

                  if(($res = mysqli_query($this->db_link, $request))===false)
                  {
                     $this->triggerError(__FUNCTION__, mysqli_error($this->db_link));
                  }
                  
                  $res = mysqli_fetch_assoc($res);
                  /* Getting ID of existing row */
                  $insert_id = $res[$auto_inc_field];
                  
               }/* END IF row wasn't inserted */
               
               
               
               /* Save ID mapping from data present in file TO row inserted (or already existing) in DB */
               $table_id_mapping[$table_name][$row[$auto_inc_field]] = $insert_id;
               
            } /* END LOOP Going through table rows */
         
         }/* END LOOP Going through tables */
         
         
         /* If simulation, we rollback the transaction */
         if($simulation)mysqli_rollback($this->db_link);
         
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



   /***********************************************************************/
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
   


   /***************************************************************************/
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
      /** Step 1 : Get "reference" configuration in tables **/
      case 1:
      {
         echo "Getting settings before configuration of plugin $plugin_name... ";

         $pc->extractAndSaveConfigReference();
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

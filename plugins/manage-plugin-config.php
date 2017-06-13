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
      - Add "unique" key information for option tables
      - Add new option table (wp_postmeta)
      - Add information about table relation (not real foreign keys but exists) to be able to map correctly 
        the information we add between them (keep the mapping and avoid conflicts)
      - Handle foreign values already existing in DB (not present in the configuration save file)
      - Handle rows that are deleted and recreated with another ID (bigger) by the plugin. Duplicate entry 
        error is handled and existing row id is recovered
      
   TODO :
   - Add error check (existing files, etc...)
   - 

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
   8. Reinstall WordPress from scratch
   9. Execute STEP 3 of this script to import plugin configuration.
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
      var $tables_relations;
   
      
      /*
         GOAL : Class contructor
         
         $plugin_name   : Plugin name for which we want to manage the configuration
      */     
      function PluginConfig($plugin_name)
      {
         $this->plugin_name = $plugin_name;
         $this->wp_tables   = array();
         
         /* Tables in which configuration is stored, with 'auto gen id' fields and 'unique field' (others than only auto-gen field). Those tables must be sorted to satisfy foreign keys*/
         $this->config_tables = array('wp_postmeta'             => array('meta_id', null),
                                      'wp_options'              => array('option_id', 'option_name'),
                                      'wp_terms'                => array('term_id', null),
                                      'wp_termmeta'             => array('meta_id', null), // include wp_terms.term_id
                                      'wp_term_taxonomy'        => array('term_taxonomy_id', null), // include wp_terms.term_id
                                      'wp_term_relationships'   => array(null, array('object_id', 'term_taxonomy_id'))); // include wp_term_taxonomy.term_taxonomy_id
         
         /* Relation between configuration tables. There are no explicit relation between tables in DB but there are relation coded in WP. */                             
         $this->tables_relations = array('wp_termmeta'            => array('term_id' => 'wp_terms'),
                                         'wp_term_taxonomy'       => array('term_id' => 'wp_terms'),
                                         'wp_term_relationships'  => array('term_taxonomy_id' => 'wp_term_taxonomy'));
                                         
         
         
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
         GOAL  : Take a "snapshot" of configuration tables before plugin configuration.
                 In fact, we get max ID for each tables in which configuration is stored.
                 
                 The information are saved in a file
      */
      function extractAndSaveConfigSnapshot()
      {
      
         $base_config = array();
         
         /* Going throught tables */
         foreach($this->config_tables as $table_name => $fields_infos)
         {
            /* Extract infos */
            list($id_field, $unique_fields) = $fields_infos;
      
            /* if no $id field, we skip */
            if($id_field === null) continue;

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
         foreach($this->config_tables as $table_name => $fields_infos)
         {
            /* Extract infos */
            list($id_field, $unique_fields) = $fields_infos;
            
            /* Get diff for table */
            $request = "SELECT * FROM $table_name";
            /* If there's an ID field */
            if($id_field!==null) $request.= " WHERE $id_field > $base_config[$table_name]";
            
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
            list($id_field, $unique_fields) = $fields_infos;

            /* Creating mapping array for current table */
            $table_id_mapping[$table_name] = array();

            /* Going through rows to add in table */
            foreach($diff_config[$table_name] as $row)
            {
               $values = array();
               /* Goint through fields/values in the row */
               foreach($row as $field => $value)
               {

                  /* If current field contains an "auto-generated id", */
                  if($id_field==$field)
                  {
                     /* Empty value so it will be generated automatically */
                     $values[] = '';
                  }
                  /* If we have information about foreign key, */
                  else if(($target_table = $this->getForeignKeyTable($table_name, $field))!==null)
                  { 
                     /* If we have a mapping for the current value, */
                     if(array_key_exists($value, $table_id_mapping[$target_table]))
                     {
                        /* Getting mapped id for current value */
                        $values[] = $table_id_mapping[$target_table][$value];
                        
                     }
                     else /* We don't have any mapping */
                     {
                        /* We take the value as it is because it is probably referencing something already existing in the DB 
                           (and not present in the saved configuration for the plugin) */
                        $values[] = $value;
                        
                     }
                  }
                  else /* We can take the value present in the config file (with 'addslashes' to be sure) */
                  {
                     $values[] = addslashes($value);
                  }
                  
               }/* END LOOPING through fields/values in the row*/
            
            

               $request = "INSERT IGNORE INTO $table_name VALUES('".implode("','", $values)."')";

               if(($res = mysqli_query($this->db_link, $request))===false)
               {
                  trigger_error(__FUNCTION__.": ".mysqli_error($this->db_link)."\n", E_USER_ERROR);
               }
               
               /* Getting ID of inserted value */
               $insert_id = mysqli_insert_id($this->db_link);
               
               
               
               /* If row wasn't inserted because already exists, (so it means we must have an 'auto-gen' field) */
               if($insert_id==0 && $id_field !== null)
               {
                  /* Array transform if needed */
                  if(!is_array($unique_fields)) $unique_fields = array($unique_fields);
                  
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
                     trigger_error(__FUNCTION__.": ".mysqli_error($this->db_link)."\n", E_USER_ERROR);
                  }
                  
                  $res = mysqli_fetch_assoc($res);
                  /* Getting ID of existing row */
                  $insert_id = $res[$id_field];
                  
               }/* END IF row wasn't inserted */
               
               
               
               /* Save ID mapping from data present in file TO row inserted in DB */
               $table_id_mapping[$table_name][$row[$id_field]] = $insert_id;
               
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

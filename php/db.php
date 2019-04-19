<?php
if ( !class_exists('VMS_DB') ) {

	class VMS_DB {

    private static $instance = null;

    private function __construct() {
    }

    public static function getInstance() {
      if (self::$instance == null)
      {
        self::$instance = new VMS_DB();
      }

      return self::$instance;
    }

    function generateDB() {
      global $wpdb;

      $table_name = $wpdb->prefix . "vms_nations";

      $charset_collate = $wpdb->get_charset_collate();

      $sql = "CREATE TABLE $table_name (
        id MEDIUMINT(9) NOT NULL AUTO_INCREMENT,
        it TINYTEXT NOT NULL,
        en TINYTEXT NOT NULL,
        PRIMARY KEY  (id)
      ) $charset_collate;";


      $table_name = $wpdb->prefix . "vms_categories";

      $sql .= "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        it tinytext NOT NULL,
        en tinytext NOT NULL,
        gruppo tinytext NOT NULL,
        sigla tinytext NOT NULL,
        needs_display boolean DEFAULT 0,
        PRIMARY KEY  (id)
      ) $charset_collate;";

      $table_name = $wpdb->prefix . "vms_models";

      $sql .= "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        title tinytext NOT NULL,
        categoryId INT,
        modelistId INT,
        PRIMARY KEY  (id),
        FOREIGN KEY (categoryId) REFERENCES ". $wpdb->prefix . "vms_categories(id),
        FOREIGN KEY (modelistId) REFERENCES ". $wpdb->prefix . "users(ID)
      ) $charset_collate;";

      $table_name = $wpdb->prefix . "vms_displays";

      $sql .= "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        modelistId int,
				categoryId int,
        PRIMARY KEY (id),
        FOREIGN KEY (modelistId) REFERENCES ". $wpdb->prefix . "users(ID),
				FOREIGN KEY (categoryId) REFERENCES ". $wpdb->prefix . "vms_categories(id)
      ) $charset_collate;";


      require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
      dbDelta( $sql );
    }


    function generateDataset() {
      global $wpdb;

			//Nations

			$table_name = $wpdb->prefix . "vms_nations";
			$count = $wpdb->get_var("SELECT COUNT(*) FROM " . $table_name );
			if($count == 0) {

	      require_once (plugin_dir_path(__FILE__). '../src/utils/nations.php');

	      foreach ($nations_array as $nation) {
	        $wpdb->insert(
	          $table_name,
	          array(
	            'it' => $nation['it'],
	            'en' => $nation['en']
	          )
	        );
	      }
			}

      //Categories

      $table_name = $wpdb->prefix . "vms_categories";
			$count = $wpdb->get_var("SELECT COUNT(*) FROM " . $table_name );

			if($count == 0) {

				require_once (plugin_dir_path(__FILE__). '../src/utils/categories.php');

	      foreach ($categories_array as $category) {

	        $needs_display = ($category['needs_display'])?$category['needs_display']:false;

	        $wpdb->insert(
	          $table_name,
	          array(
	            'gruppo' => ucfirst(strtolower($category['gruppo'])),
	            'sigla' => $category['sigla'],
	            'needs_display' => $needs_display,
	            'it' => $category['it'],
	            'en' => $category['en']
	          )
	        );
	      }
			}
    }

    function clearDB() {

      global $wpdb;

      $table_name = $wpdb->prefix . 'vms_nations';
      $sql = "DELETE FROM $table_name";

      $wpdb->query($sql);

      $table_name = $wpdb->prefix . 'vms_categories';
      $sql = "DELETE FROM $table_name";

      $wpdb->query($sql);

      $table_name = $wpdb->prefix . 'vms_models';
      $sql = "DELETE FROM $table_name";

      $wpdb->query($sql);

      $table_name = $wpdb->prefix . 'vms_displays';
      $sql = "DELETE FROM $table_name";

      $wpdb->query($sql);
    }

    function dropDB() {
      global $wpdb;

      $table_name = $wpdb->prefix . 'vms_nations';
      $sql = "DROP TABLE IF EXISTS $table_name";

      $wpdb->query($sql);

      $table_name = $wpdb->prefix . 'vms_categories';
      $sql = "DROP TABLE IF EXISTS $table_name";

      $wpdb->query($sql);

      $table_name = $wpdb->prefix . 'vms_models';
      $sql = "DROP TABLE IF EXISTS $table_name";

      $wpdb->query($sql);

      $table_name = $wpdb->prefix . 'vms_displays';
      $sql = "DROP TABLE IF EXISTS $table_name";

      $wpdb->query($sql);
    }

    function get_page_list() {
			$args = array(
				'sort_order' => 'asc',
				'sort_column' => 'post_title',
				'post_type' => 'page',
			);
			return  get_pages($args);
		}

		function get_nations_list() {

			global $wpdb;

			$nation_locale_id = (get_locale() == "it_IT")? "it" : "en";

			$table_name = $wpdb->prefix . "vms_nations";
			$nations = $wpdb->get_results("SELECT id," . $nation_locale_id .  " AS name FROM " . $table_name );
			return $nations;
		}

		function get_nation_with_id($id) {
			global $wpdb;

			$nation_locale_id = (get_locale() == "it_IT")? "it" : "en";

			$table_name = $wpdb->prefix . "vms_nations";
			$nations = $wpdb->get_row("SELECT id," . $nation_locale_id .  "  AS name FROM " . $table_name . " WHERE id=" . $id );
			return $nations;
		}

		function get_categories_list() {

			global $wpdb;

			$category_locale_id = (get_locale() == "it_IT")? "it" : "en";

			$table_name = $wpdb->prefix . "vms_categories";
			$categories = $wpdb->get_results("SELECT id, gruppo, sigla, " . $category_locale_id .  " AS name FROM " . $table_name );
			return $categories;
		}

		function get_category_with_id($category_id) {
			global $wpdb;

			$table_name = $wpdb->prefix . "vms_categories";
			$category = $wpdb->get_row("SELECT * FROM " . $table_name . " WHERE id=" . $category_id );
			return $category;
		}

		function get_models_list_for_modelist($modelist_id) {
			global $wpdb;

			$category_locale_id = (get_locale() == "it_IT")? "it" : "en";

			$models_table = $wpdb->prefix . "vms_models";
			$category_table = $wpdb->prefix . "vms_categories";
			$display_table = $wpdb->prefix . "vms_displays";

			$query = "SELECT " . $models_table . ".id, " . $models_table .".title, " .
			 									 $category_table . "." . $category_locale_id . " AS category, " .
												 $category_table . ".sigla AS sigla, " .
												 $models_table . ".categoryId, " .
												 "IF(" . $category_table . ".needs_display = 1, " . $display_table . ".id, null) AS display" .
												 " FROM " . $models_table .
												 " LEFT JOIN " . $category_table . " ON " . $models_table .".categoryId=" . $category_table.".ID" .
												 " INNER JOIN " . $display_table . " ON " . $models_table .".modelistId=" . $display_table.".modelistId" .
												 " WHERE " .  $models_table . ".modelistId=" . $modelist_id ;
			$models = $wpdb->get_results($query);
			return $models;
		}

		function get_models_list_for_category($category_id) {
			global $wpdb;

			$category_locale_id = (get_locale() == "it_IT")? "it" : "en";

			$models_table = $wpdb->prefix . "vms_models";
			$category_table = $wpdb->prefix . "vms_categories";
			$display_table = $wpdb->prefix . "vms_displays";

			$query = "SELECT " . $models_table . ".id, " . $models_table .".title, " .
												 $category_table . "." . $category_locale_id . " AS category, " .
												 $category_table . ".sigla AS sigla, " .
												 $models_table . ".modelistId," .
												 $models_table . ".categoryId, " .
												 "IF(" . $category_table . ".needs_display = 1, " . $display_table . ".id, null) AS display" .
												 " FROM " . $models_table .
												 " INNER JOIN " . $category_table . " ON " . $models_table .".categoryId=" . $category_table.".ID" .
												 " LEFT JOIN " . $display_table . " ON " . $models_table .".modelistId=" . $display_table.".modelistId" .
												 " WHERE " .  $models_table . ".categoryId=" . $category_id;
			$models = $wpdb->get_results($query);
			return $models;
		}


		function get_display_for_modelist($modelist_id, $category_id) {
			global $wpdb;

			$table_name = $wpdb->prefix . "vms_displays";
			$display = $wpdb->get_row("SELECT * FROM " . $table_name . " WHERE modelistId=" . $modelist_id . " AND categoryId=" . $category_id );

			return $display;
		}

		function get_displays_list() {
			global $wpdb;
			$table_name = $wpdb->prefix . "vms_displays";

			$display = $wpdb->get_results("SELECT * FROM " . $table_name );
			return $display;
		}


		function get_models_for_display($display_id) {
			global $wpdb;

			$models_table = $wpdb->prefix . "vms_models";
			$category_table = $wpdb->prefix . "vms_categories";
			$display_table = $wpdb->prefix . "vms_displays";

			$query = "SELECT " . $models_table .".title, " .
												 $category_table . ".sigla AS sigla" .
												 " FROM " . $models_table .
												 " INNER JOIN " . $category_table . " ON " . $models_table .".categoryId=" . $category_table.".ID" .
												 " LEFT JOIN " . $display_table . " ON " . $models_table .".modelistId=" . $display_table . ".modelistId" .
												 " WHERE " .  $display_table . ".id=" . $display_id;

			$models = $wpdb->get_results($query);
			return $models;
		}

		function create_display_for_modelist($modelist_id, $category_id) {
			global $wpdb;
			$table_name = $wpdb->prefix . "vms_displays";

			$query = "INSERT INTO ". $table_name .
							 "(modelistId, categoryId) VALUES ('" . $modelist_id ."','" . $category_id . "')";
			$display = $wpdb->get_results($query);
			return $display;
		}

		function create_new_model( $title, $category_id, $modelist_id) {
			global $wpdb;
			$table_name = $wpdb->prefix . "vms_models";

			$category = $this->get_category_with_id($category_id);

			if($category->needs_display) {
					if( !$this->get_display_for_modelist($modelist_id, $category_id) ){
						$this->create_display_for_modelist($modelist_id, $category_id);
					}
			}

			$query = "INSERT INTO ". $table_name .
						"(title, categoryId, modelistId) VALUES ('". $title. "','" . $category_id . "','" . $modelist_id ."')";
			$model = $wpdb->get_results( $query );
			return $model;
		}

		function update_model ( $model_id, $title, $category_id, $modelist_id ) {
			global $wpdb;
			$table_name = $wpdb->prefix . "vms_models";

			$category = $this->get_category_with_id($category_id);

			if($category->needs_display) {
					if( !$this->get_display_for_modelist($modelist_id) ){
						$this->create_display_for_modelist($modelist_id);
					}
			}

			$query = 'UPDATE '. $table_name .
							' SET title="' . $title . '", categoryId="' . $category_id .
							' " WHERE id=' . $model_id ;

			$model = $wpdb->get_results( $query );
			return $model;
		}

		function delete_model ( $model_id ) {
			global $wpdb;
			$table_name = $wpdb->prefix . "vms_models";
			$query = 'DELETE FROM '. $table_name .
							' WHERE id=' . $model_id;

			$model = $wpdb->get_results( $query );

			return $model;
		}
  }
}
?>

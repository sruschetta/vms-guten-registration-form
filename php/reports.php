<?php

add_action('admin_menu', array($this, 'test_plugin_setup_menu') );

function test_plugin_setup_menu(){
      add_menu_page( 'Test Plugin Page', 'Test Plugin', 'manage_options', 'test-plugin', array($this, 'test_init') );
}

function test_init(){
      echo "<h1>Hello World!</h1>";
}

?>

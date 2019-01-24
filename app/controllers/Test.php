<?php

//If navigate directly to this file (rather than routed through index.php in the root dir) it will print out this.
//If the rewrite rules in the root .htaccess are setup it will not display this - will go to the default controller
echo "Test.php";

 class Test {
  public function __construct() {
    echo "Test loaded <br>";
    echo "Current Current working dir Test.php: <br/>";
    echo getcwd() . "<br/>";
    echo "Location of Test.php: <br/>";
    echo __FILE__ . "<br/>";
    echo "<br/>";

  }
  public function index() {
    echo "Test->Index is run <br>";
  }

  public function about($id) {
    echo "Test->About is run - with id = '$id' <br> ";
  }

 }

?>
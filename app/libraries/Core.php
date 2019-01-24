<?php
/*
App core class
Create URL & loads core controller
URL format: /controller/method/params
*/

class Core {
  // these change when url changes
  protected $currentController = 'Pages';
  protected $currentMethod = 'Index';
  protected $params = [];

  public function __construct() {
      $url = $this->getUrl();
      if(file_exists("../app/controllers/" . ucwords($url[0]) . ".php")) {
        //relative to the working dir, not location of this file.
        $this->currentController = ucwords($url[0]);
        unset($url[0]);
      }
      // Relative to the working directory
       require_once "../app/controllers/" . $this->currentController . ".php";

      // Instantiate controller
      $this->currentController = new $this->currentController;

      //Set the current method and params
      if(method_exists($this->currentController, $url[1])) {
        $this->currentMethod = $url[1];
        unset($url[1]);
      }
      $this->params = $url ? array_values($url) : [];

      // //Call the method with specified parameters
      call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
  }

  public function getUrl() {
    if(isset($_GET['url'])) {
      $url = rtrim($_GET['url'], '/'); //remove the last '/'
      $url = filter_var($url, FILTER_SANITIZE_URL);
      //SPLIT URL INTO AN ARRAY
      $url = explode('/', $url);
      return $url;
    }
  }
}
?>
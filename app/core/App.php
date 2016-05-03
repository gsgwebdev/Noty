<?php

class App {
  // Default values
  protected $controller = 'index';
  protected $method = 'index';
  protected $params = [];

  public function __construct() {
    $url = $this->parseUrl();

    if (file_exists(__DIR__ . '/../controllers/' . $url[0] . '.php')) {
      $this->controller = $url[0];
      unset($url[0]);
    } else {
      $this->controller = 'errors';
    }

    require_once(__DIR__ . '/../controllers/' . $this->controller . '.php');

    // Create a new instance of the controller
    $this->controller = new $this->controller;

    if (isset($url[1])) {
      if (method_exists($this->controller, $url[1])) {
        $this->method = $url[1];
        unset($url[1]);
      }
    }

    // Rebase the indexes of params array if they exist
    $this->params = $url ? array_values($url) : [];

    // Call the controller's method with given params
    call_user_func_array([$this->controller, $this->method], $this->params);
  }

  protected function parseUrl() {
    if (isset($_GET['rt'])) {
      /*
       * Split the URL into
       * Controller([0]), Method([1]) and Parameters([2+])
       * and return them as an array
       */
      return $url = explode('/', filter_var(rtrim($_GET['rt'], '/'), FILTER_SANITIZE_URL));
    }
  }
}
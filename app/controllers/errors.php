<?php

class Errors extends Controller {
  public function index() {
    $this->err404();
  }

  public function err404() {
    $this->view('404');
  }
}
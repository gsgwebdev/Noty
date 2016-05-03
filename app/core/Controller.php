<?php

abstract class Controller {
  abstract public function index();

  public function view($view, $data = []) {
    require_once(__DIR__ . '/../views/' . $view . '.php');
  }

  protected function model($model_name, $argms = []) {
    require_once(__DIR__ . '/../models/' . $model_name . '.php');
    return $model = new $model_name($argms);
  }
}
<?php

function setLink($controller, $method='') {
  return "http://{$_SERVER['HTTP_HOST']}/notyMVC/public/{$controller}/{$method}";
}
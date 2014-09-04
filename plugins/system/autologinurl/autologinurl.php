<?php

defined('_JEXEC') or die();

class plgSystemAutologinurl extends JPlugin {

  function onAfterInitialise() {
    $app = JFactory::getApplication('site');
    $jinput = $app->input;
    $credentials = array();
    // determina los nombres de los parámetros en base a la configuración del plugin
    $userparam = $this->params->get('userparam');
    $pwparam = $this->params->get('pwparam');
    // toma los parámetros de la url para utilizarlos en el login
    $credentials['username'] = $jinput->get($userparam);
    $credentials['password'] = $jinput->get($pwparam);
    // si los dos parámetros están presentes intenta logearse
    if (!empty($credentials['username']) && !empty($credentials['password'])) {
      $resultado = $app->login($credentials);
    }
  }

}
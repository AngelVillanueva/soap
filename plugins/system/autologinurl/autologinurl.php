<?php

defined('_JEXEC') or die();

class plgSystemAutologinurl extends JPlugin {

  function onAfterInitialise() {
    $app = JFactory::getApplication('site');
    $jinput = $app->input;
    $credentials = array();

    $userparam = $this->params->get('userparam');
    $pwparam = $this->params->get('pwparam');

    $credentials['username'] = $jinput->get($userparam);
    $credentials['password'] = $jinput->get($pwparam);

    if (!empty($credentials['username']) && !empty($credentials['password'])) {
      $resultado = $app->login($credentials);
    }
  }

}
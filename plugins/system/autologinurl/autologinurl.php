<?php

defined('_JEXEC') or die();

class plgSystemAutologinurl extends JPlugin {

  function onAfterInitialise() {
    $app = JFactory::getApplication('site');
    $jinput = $app->input;
    $credentials = array();

    $credentials['username'] = $jinput->get('UserId');
    $credentials['password'] = $jinput->get('pwd');

    $resultado = $app->login($credentials);
  }

}
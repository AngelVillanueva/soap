<?php

  /**
   * Devuelve un nombre de usuario y contraseña para los tests
   * @return array nombre de usuario('nombre':string) y contraseña('pw':string)
   */
  function datosUsuarioTest() {
    $datos = array();
    $datos['username'] = "testAdmin";
    $datos['pw'] = "contrasena";
    return $datos;
  }
  /**
   * Devuelve un usuario para los tests
   * @param  string $name nombre de usuario deseado
   * @param  string $password contraseña deseada (sin encriptar)
   * @return integer $user->id id del usuario creado
   */
  function crearUsuario($username, $password) {
    $salt   = JUserHelper::genRandomPassword(32);
    $crypted  = JUserHelper::getCryptedPassword($password, $salt);
    $cpassword = $crypted.':'.$salt;
    $data = array(
        "name"=> "test_user",
        "username"=>$username,
        "password"=>$password,
        "password2"=>$password,
        "email"=>'info@example.com',
        "block"=>0,
        "groups"=>array("1","2")
    );
    $user = new JUser;
    // Graba el usuario de test en la base de datos
    if(!$user->bind($data)) {
        throw new Exception("La estructura de datos no es correcta. Error: " . $user->getError());
    }
    if (!$user->save()) {
        //throw new Exception("Could not save user. Error: " . $user->getError());
        echo "<br>No pudo grabarse el usuario $name - " . $user->getError();
    }
    // Devuelve el id del usuario recién creado
    return $user->id;
  }
  /**
   * busca un usuario en la base de datos Joomla a partir de su nombre
   * @param  string $name nombre del usuario
   * @return object usuario o null
   */
  function buscarUsuario($username) {
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);
    $query->select('id');
    $query->from($db->quoteName('#__users'));
    $query->where($db->quoteName('username')." = ".$db->quote($username));

    $db->setQuery($query);
    $result = $db->loadObject();

    return $result;
  }
  /**
   * borra un usuario de la base de datos a partir de su nombre
   * @param  string $name nombre del usuario
   * @return boolean       true para éxito, false para fracaso
   */
  function borrarUsuario($username) {
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);
    $query->select('id');
    $query->from($db->quoteName('#__users'));
    $query->where($db->quoteName('username')." = ".$db->quote($username));

    $db->setQuery($query);
    $result = $db->loadObject();
    $test_user = JUser::getInstance($result->id);
    $test_user->delete();
  }
  /**
   * Devuelve una url precedida con http://  terminada en / si no tiene ese formato
   * @return string url formada
   */
  function addhttp($url) {
    if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
        $url = "http://" . $url;
    }
    if (substr($url, -1) !== "/") {
        $url = $url."/";
    }
    return $url;
    
  }
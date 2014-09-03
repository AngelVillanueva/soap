<?php
  function datosUsuarioTest() {
    $datos = array();
    $datos['nombre'] = "testAdmin";
    $datos['pw'] = "contrasena";
    return $datos;
  } 
  function crearUsuario($name, $password) {
    $salt   = JUserHelper::genRandomPassword(32);
    $crypted  = JUserHelper::getCryptedPassword($password, $salt);
    $cpassword = $crypted.':'.$salt;
    $data = array(
        "name"=> $name,
        "username"=>'TestAdmin',
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
  function buscarUsuario($name) {
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);
    $query->select('id');
    $query->from($db->quoteName('#__users'));
    $query->where($db->quoteName('name')." = ".$db->quote($name));

    $db->setQuery($query);
    $result = $db->loadObject();

    return $result;
  }
  function borrarUsuario($name) {
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);
    $query->select('id');
    $query->from($db->quoteName('#__users'));
    $query->where($db->quoteName('name')." = ".$db->quote($name));

    $db->setQuery($query);
    $result = $db->loadObject();
    $test_user = JUser::getInstance($result->id);
    $test_user->delete();
  }
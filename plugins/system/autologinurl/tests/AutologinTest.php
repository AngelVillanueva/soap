<?php

class AutologinTest extends \PHPUnit_Framework_TestCase {
    
    public function setUp() {
        // inicia aplicación Joomla
        $app = JFactory::getApplication('site');
        // recupera el nombre y contraseña de un usuario de test
        // desde tests/test_helpers.php
        $name = datosUsuarioTest()['nombre'];
        $pw = datosUsuarioTest()['pw'];
        // crea un usuario de prueba si no existe
        if(!$existingUserTest = buscarUsuario($name) ){
            $test_user = crearUsuario($name, $pw);
        }
        
    }  
    
    /**
     * Test para comprobar que el usuario de prueba se autologea utilizando
     * sus credenciales en la URL de entrada
     * @var string $css_element Sólo debe aparecer cuando el usuario está logeado
     * @return boolean True si el test pasa
     */
    public function testAutologin() {
        // inicializa valores
        // utilizar los mismos valores para $name, $password que en setUp()
        $app = JFactory::getApplication('site');
        $css_element = "logout-button";
        $name = datosUsuarioTest()['nombre'];
        $password = datosUsuarioTest()['pw'];
        // accede a la aplicación utilizando cURL
        $curl = curl_init("http://localhost:8888/soap/index.php?UserId=$name&pwd=$password");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $resultado = curl_exec($curl);
        // TRUE si la página contiene el elemento css que sólo aparece cuando
        // el usuario está logeado
        $this->assertContains($css_element, $resultado);
    }

    /**
     * Test para comprobar que el usuario de prueba no se autologea utilizando
     * sus credenciales en la URL de entrada si estas son incorrectas
     * 
     * @var string $css_element Sólo debe aparecer cuando el usuario está logeado
     * @return boolean True si el test pasa
     */
    public function testAutologinIncorrecto() {
        // inicializa valores
        // utilizar los mismos valores para $name, $password que en setUp()
        $app = JFactory::getApplication('site');
        $css_element = "logout-button";
        $name = datosUsuarioTest()['nombre'];
        $password = datosUsuarioTest()['pw'];
        // cambio las credenciales para que sean incorrectas
        $name = $name."a";
        // accede a la aplicación utilizando cURL
        $curl = curl_init("http://localhost:8888/soap/index.php?UserId=$name&pwd=$password");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $resultado = curl_exec($curl);
        // TRUE si la página contiene el elemento css que sólo aparece cuando
        // el usuario está logeado
        $this->assertNotContains($css_element, $resultado);
    }

    /**
     * @afterClass
     * borra el usuario creado para el test después de realizar los tests
     */
    public static function tearDownTestUserAfter() {
        borrarUsuario("testAdmin");
    }
     
}
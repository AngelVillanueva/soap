<?php

class AutologinTest extends \PHPUnit_Framework_TestCase {
    
    public function setUp() {
        // inicia aplicación Joomla
        $app = JFactory::getApplication('site');
        // recupera el nombre y contraseña de un usuario de test
        // desde tests/test_helpers.php
        $username = datosUsuarioTest()['username'];
        $pw = datosUsuarioTest()['pw'];
        // crea un usuario de prueba si no existe
        if(!$existingUserTest = buscarUsuario($username) ){
            $test_user = crearUsuario($username, $pw);
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
        $username = datosUsuarioTest()['username'];
        $password = datosUsuarioTest()['pw'];
        // importa el plugin de Autologinurl y recupera el parámetro URL de entrada
        $plugin = JPluginHelper::getPlugin('system', 'autologinurl');
        $params = new JRegistry($plugin->params);
        $aplicacion_web_url = addhttp($params->get('url_aplicacion'));
        $userparam = $params->get('userparam');
        $pwparam = $params->get('pwparam');
        // accede a la aplicación utilizando cURL
        $curl = curl_init("$aplicacion_web_url?$userparam=$username&$pwparam=$password");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $resultado = curl_exec($curl);
        // TRUE si la página contiene el elemento css que sólo aparece cuando
        // el usuario está logeado
        $this->assertContains($css_element, $resultado);
    }

    /**
     * Test para comprobar que el usuario de prueba no se autologea utilizando
     * sus credenciales en la URL de entrada si el username es incorrecto
     * 
     * @return boolean True si el test pasa
     */
    public function testAutologinNombreIncorrecto() {
        // inicializa valores
        // utilizar los mismos valores para $name, $password que en setUp()
        $app = JFactory::getApplication('site');
        $css_element = "logout-button";
        $username = datosUsuarioTest()['username'];
        $password = datosUsuarioTest()['pw'];
        // cambio el nombre de usuario para que sea incorrecto
        $username = $username."a";
        // importa el plugin de Autologinurl y recupera el parámetro URL de entrada
        $plugin = JPluginHelper::getPlugin('system', 'autologinurl');
        $params = new JRegistry($plugin->params);
        $aplicacion_web_url = addhttp($params->get('url_aplicacion'));
        $userparam = $params->get('userparam');
        $pwparam = $params->get('pwparam');
        // accede a la aplicación utilizando cURL
        $curl = curl_init("$aplicacion_web_url?$userparam=$username&$pwparam=$password");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $resultado = curl_exec($curl);
        // TRUE si la página contiene el elemento css que sólo aparece cuando
        // el usuario está logeado
        $this->assertNotContains($css_element, $resultado);
    }

    /**
     * Test para comprobar que el usuario de prueba no se autologea utilizando
     * sus credenciales en la URL de entrada si la contraseña es incorrecta
     * 
     * @return boolean True si el test pasa
     */
    public function testAutologinPasswordIncorrecta() {
        // inicializa valores
        // utilizar los mismos valores para $name, $password que en setUp()
        $app = JFactory::getApplication('site');
        $css_element = "logout-button";
        $username = datosUsuarioTest()['username'];
        $password = datosUsuarioTest()['pw'];
        // cambio la contraseña para que sea incorrecto
        $password = $password."ab";
        // importa el plugin de Autologinurl y recupera el parámetro URL de entrada
        $plugin = JPluginHelper::getPlugin('system', 'autologinurl');
        $params = new JRegistry($plugin->params);
        $aplicacion_web_url = addhttp($params->get('url_aplicacion'));
        $userparam = $params->get('userparam');
        $pwparam = $params->get('pwparam');
        // accede a la aplicación utilizando cURL
        $curl = curl_init("$aplicacion_web_url?$userparam=$username&$pwparam=$password");
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
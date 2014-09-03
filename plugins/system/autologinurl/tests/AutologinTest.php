<?php

class AutologinTest extends \PHPUnit_Framework_TestCase {
    
    /**
    * previamente creamos un usario de pruebas
    * @var string $name Nombre para el usuario de pruebas
    * @var string $password Constraseña para el usuario de pruebas
    * @return integer Id del usuario de pruebas creado
    */
    public function setUp() {
        // inicia aplicación Joomla
        $app = JFactory::getApplication('site');
        // 
        // crea una matriz con los datos de un usuario de test
        if($existingUserTest = buscarUsuario("testAdmin") ){
            $existing = JUser::getInstance($existingUserTest->id);
            $existing->delete();
        }
        $test_user = crearUsuario("testAdmin", "contrasena");
    }  
    
    /**
     * Test para comprobar que el usuario de prueba se autologea utilizando
     * sus credenciales en la URL de entrada
     * 
     * @var string $css_element Sólo debe aparecer cuando el usuario está logeado
     * @return boolean True si el test pasa
     */
    public function testAutologin() {
        // inicializa valores
        // utilizar los mismos valores para $name, $password que en setUp()
        $app = JFactory::getApplication('site');
        $css_element = "logout-button";
        $name = "testAdmin";
        $password = "contrasena";
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
        $name = "testAdmins";
        $password = "contrasena";
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
     * borrar el usuario creados para el test después de realizar los tests
     */
    public static function tearDownTestUser() {
        $name = "testAdmin";

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
     
}
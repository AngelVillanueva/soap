<?php

class AutologinTest extends \PHPUnit_Framework_TestCase {
    public function setUp() {
        $app = JFactory::getApplication('site');
        $input = $app->input;
        $input->set('UserId','nombre_de_usuario');
        $controller = JControllerLegacy::getInstance('Content');
        $controller->execute('');
    }  
    public function testAutologin() {
        $user = JFactory::getUser();
        $this->assertTrue($user->id, true);
    }
     
}
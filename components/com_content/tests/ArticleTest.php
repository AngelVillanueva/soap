<?php
//include JPATH_COMPONENT.'/content.php';
 
class ArticleTest extends \PHPUnit_Framework_TestCase {
    public function setUp() {      
         
    }  
    public function testSingleArticle(){
        $input = JFactory::getApplication('site')->input;
        $input->set('id',1);
        $input->set('view','article');                  
        $input->set('option','com_content');    
        $controller = JControllerLegacy::getInstance('Content');
        $controller->execute('');       
    }      
    public function testListArticles() {
        $c = new ContentController();      
        $model = $c->getModel('articles');
        $articles = $model->getItems();
        var_dump($articles);
        $this->assertNotEmpty($articles);
    }
     
}
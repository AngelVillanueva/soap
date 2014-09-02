<?php
class ArticleTest extends \PHPUnit_Framework_TestCase {
         
    protected function setUp()
    {
        $app = JFactory::getApplication('administrator');
        //initialize session and user
        $session = JFactory::getSession();
        $session->set('user', JUser::getInstance('admin'));
        //bypass JSession::checkToken()
        JFactory::getApplication()->input->post->set(JSession::getFormToken(),'1');
    }   
    public function testListArticles(){   
        $c = new ContentController();     
        $model = $c->getModel('articles');
        $articles = $model->getItems();
        //var_dump($articles);
        $this->assertNotEmpty($articles);
    }
    public function testSearchArticles(){
        //simulate user request: searching for 'about'
        $input = JFactory::getApplication()->input;
        $input->set('filter_search', 'about');
          
        $c = new ContentController();     
        $model = $c->getModel('articles');             
        $articles = $model->getItems();
        //var_dump($articles);
        $this->assertNotEmpty($articles);
    }
}
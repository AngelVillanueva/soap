<?php
class ArticleTest extends \PHPUnit_Framework_TestCase {
         
    public function testListArticles(){    
        $input = JFactory::getApplication('administrator')->input; // added after avoiding the unserialized offset error by commenting the line in _bootstrap.php

        $c = new ContentController();      
        $model = $c->getModel('articles');
        $articles = $model->getItems();
        var_dump($articles);
        $this->assertNotEmpty($articles);
    }
}
<?php
require_once 'BaseTestModel.php';

class unit_CategoryTest extends BaseTestModel
{
    public function testToString() {
        $name = md5(uniqid());
        $c = new Category();
        $c->setName($name);
        
        $this->assertEquals($name, (string)$c, 'Category toString to be the name');
    }
}
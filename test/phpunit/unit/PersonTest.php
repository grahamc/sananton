<?php
require_once 'BaseTestModel.php';

class unit_PersonTest extends BaseTestModel
{
  public function testToString()
  {
      $name = md5(uniqid());
      
      $m = new Person();
      $m->setName($name);
      $this->assertEquals($name, (string)$m, '__toString uses name.');
  }
  
  public function testIsValidated() {
      $m = new Person();
      $this->assertEquals(false, $m->isValidated(), 'A new person may not start validated.');
      
      $m->save();
      $this->assertEquals(false, $m->isValidated(), 'A saved person may not start validated.');
            
      $m->setValidatedAt(time());
      $this->assertEquals(true, $m->isValidated(), 'When validated_at has a time, it is validated.');
  }
}
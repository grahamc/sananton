<?php
require_once 'BaseTestModel.php';

class unit_PersonPeerTest extends BaseTestModel
{
  public function testGetByEmail()
  {
      $email = 'graham@grahamc.com';
      
      $m = PersonPeer::getByEmail($email);
      
      $this->assertTrue($m instanceof Person, 'Result should be a Person object');
      $this->assertEquals($email, $m->getEmail(), 'The email shoudl match the requested email.');
  }
  
  public function testGetActiveByPage() {
      $r1 = PersonPeer::getActiveByPage(1, 1);
      $this->assertEquals(1, count($r1), 'There should be a single result');
      
      $r2 = PersonPeer::getActiveByPage(2, 1);
      $this->assertEquals(1, count($r1), 'There should be a single result');
      
      $this->assertNotEquals($r1, $r2, 'The two results should be different pages of data.');
  }
  
  public function testGetActive() {
      $ps = PersonPeer::getActive();
      $this->assertEquals(31, count($ps), 'There should only be two active users.');
      
      foreach ($ps as $p) {
          $this->assertTrue($p instanceof Person, 'All results should be a Person object.');
		  $this->assertTrue($p->isValidated(), 'All results should be validated.');
      }
  }
  
  public function testCountActive() {
      $this->assertEquals(31, PersonPeer::countActive(), 'Starts at 2 active users');
      
      $this->createInactiveUser();
      $this->assertEquals(31, PersonPeer::countActive(), 'Adding another inactive user should not increase the number.');
  }
  
  protected function createInactiveUser() {
      $p = new Person();
      $p->setName('foo');
      $p->save();
      
      return $p;
  }
}
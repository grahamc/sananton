<?php
require_once 'BaseTestModel.php';

class unit_PersonHashTest extends BaseTestModel
{
  public function buildModel() {  
      $m = new PersonHash();
      $m->setPerson(PersonPeer::doSelectOne(new Criteria()));
      $m->setCreatedAt(time());
      
      return $m;
  }
    
  public function testToString()
  {
      $m = $this->buildModel();
      
      $str = md5(time());
      $m->setHash($str);
      
      $this->assertEquals($str, (string) $m, 'The string of the hash should be its internal string');
  }
  
  public function testIsOld() {
      $m = $this->buildModel();
      
      $m->setCreatedAt(strtotime('31 minutes ago'));
      $this->assertTrue($m->isOld());
  }
  
  /**
   * Make sure a new hash is not "old"
   */
  public function testIsNotOld() {
      $m = $this->buildModel();
      
      $m->setCreatedAt(strtotime('29 minutes ago'));
      $this->assertFalse($m->isOld());
  }
  
  public function testIsUsed() {
      $m = $this->buildModel();
      
      $this->assertFalse($m->isUsed(), 'A hash should not start used.');
      
      $m->makeUsed();
      $this->assertTrue($m->isUsed(), 'The hash should now be used.');
  }
  
  public function testIsValid() {
      $m = $this->buildModel();
      
      $this->assertTrue($m->isValid(), 'The has should be valid at start.');

      $m->setCreatedAt(strtotime('31 minutes ago'));
      $this->assertFalse($m->isValiD(), 'Time should invalidate it.');
      $m->setCreatedAt(strtotime('29 minutes ago'));
      
      $m->makeUsed();
      $this->assertFalse($m->isValid(), 'A used hash is not valid');

      $m->setCreatedAt(strtotime('31 minutes ago'));
      $this->assertFalse($m->isValiD(), 'Time and usage should invalidate it.');

  }
}
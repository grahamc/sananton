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
  
  public function testImageFSPath() {
      $m = new Person();
      $this->assertEquals(null, $m->getImageFSPath(), 'A new person has no image.');
      
      $img = md5(uniqid());
      $m->setImage($img);
      $this->assertContains($img, $m->getImageFSPath(), 'The filesystem path should contain the original filename.');
  }
  
  public function testImageWebPath() {
      $m = new Person();
      $this->assertContains('gravatar', $m->getImageWebPath(), 'A user without an image should use Gravatar.');
      
      $img = md5(uniqid());
      $m->setImage($img);
      $this->assertContains($img, $m->getImageWebPath(), 'A user with an image should use that image.');
  }
  
  public function testGetCategories() {
      $m = PersonPeer::doSelectOne(new Criteria());
      $this->assertTrue($m instanceof Person);
      
      $this->assertEquals(2, count($m->getCategories()), 'The first record should have two records.');
      foreach ($m->getCategories() as $cat) {
          $this->assertTrue($cat instanceof Category, 'All results should be a Category object.');
      }
  }
  
  public function testResizeOnSave() {
      $m = new Person();
      $m->setImage('sinatra.jpg');
      $m->save();
      
      list($width, $height) = getimagesize($m->getImageFSPath());
      $this->assertEquals(200, $width, 'Saving a Person should resize the width to 200px.');
      $this->assertEquals(200, $height, 'Saving a Person should resize the height to 200px.');
  }
}
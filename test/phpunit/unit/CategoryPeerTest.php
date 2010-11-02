<?php
require_once 'BaseTestModel.php';

class unit_CategoryPeerTest extends BaseTestModel
{
  public function testDefault()
  {
      $cs = CategoryPeer::getAll();
      
      $this->assertEquals(9, count($cs));
      
      foreach ($cs as $c) {
          $this->assertTrue($c instanceof Category, 'Each result should be a category object.');
      }
  }
}
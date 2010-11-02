<?php
require_once 'BaseTestModel.php';

class unit_CategoryPeerTest extends BaseTestModel
{
  public function testDefault()
  {
      $cs = CategoryPeer::getAll();
      
      $this->assertEquals(9, count($cs), 'There are exactly 9 fixtures.');
      
      foreach ($cs as $c) {
          $this->assertTrue($c instanceof Category, 'Each result should be a category object.');
      }
  }
}
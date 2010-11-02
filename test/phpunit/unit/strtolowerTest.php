<?php
require_once dirname(__FILE__).'/../bootstrap/unit.php';

class unit_strtolowerTest extends sfPHPUnitBaseTestCase
{
  public function testDefault()
  {
      $this->assertEquals('fOo', strtolower('FOO'));
  }
}

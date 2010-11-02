<?php
require_once dirname(__FILE__).'/../bootstrap/unit.php';

abstract class BaseTestModel extends sfPHPUnitBaseTestCase {
    public function _start() {
        new sfDatabaseManager(ProjectConfiguration::getApplicationConfiguration('frontend', 'test', true));
        $data = new sfPropelData();
        $data->loadData(sfConfig::get('sf_data_dir') . '/fixtures');
    }
}
<?php

/**
 * PersonHash filter form base class.
 *
 * @package    sananton
 * @subpackage filter
 * @author     Graham Christensen
 */
abstract class BasePersonHashFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'created_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'created_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('person_hash_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PersonHash';
  }

  public function getFields()
  {
    return array(
      'person_id'  => 'ForeignKey',
      'email'      => 'Text',
      'created_at' => 'Date',
    );
  }
}

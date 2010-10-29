<?php

/**
 * PersonCategory filter form base class.
 *
 * @package    sananton
 * @subpackage filter
 * @author     Graham Christensen
 */
abstract class BasePersonCategoryFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
    ));

    $this->setValidators(array(
    ));

    $this->widgetSchema->setNameFormat('person_category_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PersonCategory';
  }

  public function getFields()
  {
    return array(
      'person_id'   => 'ForeignKey',
      'category_id' => 'ForeignKey',
    );
  }
}

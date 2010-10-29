<?php

/**
 * PersonCategory form base class.
 *
 * @method PersonCategory getObject() Returns the current form's model object
 *
 * @package    sananton
 * @subpackage form
 * @author     Graham Christensen
 */
abstract class BasePersonCategoryForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'person_id'   => new sfWidgetFormInputHidden(),
      'category_id' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'person_id'   => new sfValidatorPropelChoice(array('model' => 'Person', 'column' => 'id', 'required' => false)),
      'category_id' => new sfValidatorPropelChoice(array('model' => 'Category', 'column' => 'id', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'PersonCategory', 'column' => array('person_id', 'category_id')))
    );

    $this->widgetSchema->setNameFormat('person_category[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PersonCategory';
  }


}

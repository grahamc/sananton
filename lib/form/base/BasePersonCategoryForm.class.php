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
      'person_id'   => new sfWidgetFormPropelChoice(array('model' => 'Person', 'add_empty' => false)),
      'category_id' => new sfWidgetFormPropelChoice(array('model' => 'Category', 'add_empty' => false)),
      'id'          => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'person_id'   => new sfValidatorPropelChoice(array('model' => 'Person', 'column' => 'id')),
      'category_id' => new sfValidatorPropelChoice(array('model' => 'Category', 'column' => 'id')),
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
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

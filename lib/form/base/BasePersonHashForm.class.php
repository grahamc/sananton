<?php

/**
 * PersonHash form base class.
 *
 * @method PersonHash getObject() Returns the current form's model object
 *
 * @package    sananton
 * @subpackage form
 * @author     Graham Christensen
 */
abstract class BasePersonHashForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'person_id'  => new sfWidgetFormInputHidden(),
      'email'      => new sfWidgetFormInputHidden(),
      'created_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'person_id'  => new sfValidatorPropelChoice(array('model' => 'Person', 'column' => 'id', 'required' => false)),
      'email'      => new sfValidatorChoice(array('choices' => array($this->getObject()->getEmail()), 'empty_value' => $this->getObject()->getEmail(), 'required' => false)),
      'created_at' => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'PersonHash', 'column' => array('email')))
    );

    $this->widgetSchema->setNameFormat('person_hash[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PersonHash';
  }


}

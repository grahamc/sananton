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
      'person_id'  => new sfWidgetFormPropelChoice(array('model' => 'Person', 'add_empty' => false)),
      'hash'       => new sfWidgetFormInputHidden(),
      'used'       => new sfWidgetFormInputCheckbox(),
      'created_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'person_id'  => new sfValidatorPropelChoice(array('model' => 'Person', 'column' => 'id')),
      'hash'       => new sfValidatorChoice(array('choices' => array($this->getObject()->getHash()), 'empty_value' => $this->getObject()->getHash(), 'required' => false)),
      'used'       => new sfValidatorBoolean(),
      'created_at' => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'PersonHash', 'column' => array('hash')))
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

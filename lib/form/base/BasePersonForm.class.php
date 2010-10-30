<?php

/**
 * Person form base class.
 *
 * @method Person getObject() Returns the current form's model object
 *
 * @package    sananton
 * @subpackage form
 * @author     Graham Christensen
 */
abstract class BasePersonForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                   => new sfWidgetFormInputHidden(),
      'name'                 => new sfWidgetFormInputText(),
      'website'              => new sfWidgetFormInputText(),
      'email'                => new sfWidgetFormInputText(),
      'image'                => new sfWidgetFormInputText(),
      'validated_at'         => new sfWidgetFormDateTime(),
      'created_at'           => new sfWidgetFormDateTime(),
      'updated_at'           => new sfWidgetFormDateTime(),
      'person_category_list' => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'Category')),
    ));

    $this->setValidators(array(
      'id'                   => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'name'                 => new sfValidatorString(array('max_length' => 255)),
      'website'              => new sfValidatorString(array('max_length' => 255)),
      'email'                => new sfValidatorString(array('max_length' => 255)),
      'image'                => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'validated_at'         => new sfValidatorDateTime(array('required' => false)),
      'created_at'           => new sfValidatorDateTime(array('required' => false)),
      'updated_at'           => new sfValidatorDateTime(array('required' => false)),
      'person_category_list' => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'Category', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorAnd(array(
        new sfValidatorPropelUnique(array('model' => 'Person', 'column' => array('website'))),
        new sfValidatorPropelUnique(array('model' => 'Person', 'column' => array('email'))),
      ))
    );

    $this->widgetSchema->setNameFormat('person[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Person';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['person_category_list']))
    {
      $values = array();
      foreach ($this->object->getPersonCategorys() as $obj)
      {
        $values[] = $obj->getCategoryId();
      }

      $this->setDefault('person_category_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->savePersonCategoryList($con);
  }

  public function savePersonCategoryList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['person_category_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(PersonCategoryPeer::PERSON_ID, $this->object->getPrimaryKey());
    PersonCategoryPeer::doDelete($c, $con);

    $values = $this->getValue('person_category_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new PersonCategory();
        $obj->setPersonId($this->object->getPrimaryKey());
        $obj->setCategoryId($value);
        $obj->save();
      }
    }
  }

}

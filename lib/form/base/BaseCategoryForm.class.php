<?php

/**
 * Category form base class.
 *
 * @method Category getObject() Returns the current form's model object
 *
 * @package    sananton
 * @subpackage form
 * @author     Graham Christensen
 */
abstract class BaseCategoryForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                   => new sfWidgetFormInputHidden(),
      'name'                 => new sfWidgetFormInputText(),
      'slug'                 => new sfWidgetFormInputText(),
      'person_category_list' => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'Person')),
    ));

    $this->setValidators(array(
      'id'                   => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'name'                 => new sfValidatorString(array('max_length' => 20)),
      'slug'                 => new sfValidatorString(array('max_length' => 20)),
      'person_category_list' => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'Person', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorAnd(array(
        new sfValidatorPropelUnique(array('model' => 'Category', 'column' => array('name'))),
        new sfValidatorPropelUnique(array('model' => 'Category', 'column' => array('slug'))),
      ))
    );

    $this->widgetSchema->setNameFormat('category[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Category';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['person_category_list']))
    {
      $values = array();
      foreach ($this->object->getPersonCategorys() as $obj)
      {
        $values[] = $obj->getPersonId();
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
    $c->add(PersonCategoryPeer::CATEGORY_ID, $this->object->getPrimaryKey());
    PersonCategoryPeer::doDelete($c, $con);

    $values = $this->getValue('person_category_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new PersonCategory();
        $obj->setCategoryId($this->object->getPrimaryKey());
        $obj->setPersonId($value);
        $obj->save();
      }
    }
  }

}

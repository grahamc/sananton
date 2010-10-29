<?php

/**
 * Category filter form base class.
 *
 * @package    sananton
 * @subpackage filter
 * @author     Graham Christensen
 */
abstract class BaseCategoryFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'                 => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'slug'                 => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'person_category_list' => new sfWidgetFormPropelChoice(array('model' => 'Person', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'name'                 => new sfValidatorPass(array('required' => false)),
      'slug'                 => new sfValidatorPass(array('required' => false)),
      'person_category_list' => new sfValidatorPropelChoice(array('model' => 'Person', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('category_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function addPersonCategoryListColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(PersonCategoryPeer::CATEGORY_ID, CategoryPeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(PersonCategoryPeer::PERSON_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(PersonCategoryPeer::PERSON_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function getModelName()
  {
    return 'Category';
  }

  public function getFields()
  {
    return array(
      'id'                   => 'Number',
      'name'                 => 'Text',
      'slug'                 => 'Text',
      'person_category_list' => 'ManyKey',
    );
  }
}

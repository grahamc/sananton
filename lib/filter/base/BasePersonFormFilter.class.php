<?php

/**
 * Person filter form base class.
 *
 * @package    sananton
 * @subpackage filter
 * @author     Graham Christensen
 */
abstract class BasePersonFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'                 => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'website'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'email'                => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'image'                => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'validated_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'created_at'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'person_category_list' => new sfWidgetFormPropelChoice(array('model' => 'Category', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'name'                 => new sfValidatorPass(array('required' => false)),
      'website'              => new sfValidatorPass(array('required' => false)),
      'email'                => new sfValidatorPass(array('required' => false)),
      'image'                => new sfValidatorPass(array('required' => false)),
      'validated_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'created_at'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'person_category_list' => new sfValidatorPropelChoice(array('model' => 'Category', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('person_filters[%s]');

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

    $criteria->addJoin(PersonCategoryPeer::PERSON_ID, PersonPeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(PersonCategoryPeer::CATEGORY_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(PersonCategoryPeer::CATEGORY_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function getModelName()
  {
    return 'Person';
  }

  public function getFields()
  {
    return array(
      'id'                   => 'Number',
      'name'                 => 'Text',
      'website'              => 'Text',
      'email'                => 'Text',
      'image'                => 'Text',
      'validated_at'         => 'Date',
      'created_at'           => 'Date',
      'updated_at'           => 'Date',
      'person_category_list' => 'ManyKey',
    );
  }
}

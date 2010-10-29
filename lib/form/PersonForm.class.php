<?php

/**
 * Person form.
 *
 * @package    sananton
 * @subpackage form
 * @author     Graham Christensen
 */
class PersonForm extends BasePersonForm
{
  public function configure()
  {
      $help = array(
          'name' => 'Who are you?',
          'email' => 'Required to activate your account. Not shown, sold, or spammed.',
          'website' => 'You have one... right?',
          'image' => 'Image will be cropped t o a 200x200 square.',
          'person_category_list' => 'What are you?'
          );
      foreach ($help as $w => $h) {
          $this->widgetSchema->setHelp($w, $h);
      }
      
      $this->widgetSchema->setLabel('person_category_list', 'What are you?');
        
      $this->useFields(array('name', 'website', 'email', 'image', 'person_category_list'));
  }
}

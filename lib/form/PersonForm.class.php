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
          'email' => 'Required to activate your account.<br />Not shown, sold, or spammed.',
          'website' => 'You have one... right?',
          'image' => 'Image will be cropped t o a 200x200 square.',
          'person_category_list' => "Choose <strong>up to 3</strong> categories.<br />Don't see yours? "
                                    . '<a href="' . sfConfig::get('app_help_link') . '" target="blank">Let me know.</a>'
          );
      foreach ($help as $w => $h) {
          $this->widgetSchema->setHelp($w, $h);
      }
      
      $this->widgetSchema->setLabel('person_category_list', 'What are you?');
      $this->getWidget('person_category_list')->setOption('expanded', true);
      $this->useFields(array('name', 'website', 'email', 'image', 'person_category_list'));
  }
}

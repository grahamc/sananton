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
          'image' => 'Gravatar will be used if you don\'t upload one.<br />Uploaded image are cropped to a 200x200 square.',
          'person_category_list' => "Choose <strong>up to 3</strong> categories.<br />Don't see yours? "
                                    . '<a href="' . sfConfig::get('app_help_link') . '" target="blank">Let me know.</a>'
          );
      foreach ($help as $w => $h) {
          $this->widgetSchema->setHelp($w, $h);
      }
      
      
      $this->setValidator('image', new sfValidatorFile(array(
          'mime_types' => array('image/jpeg',
          'image/pjpeg',
          'image/png',
          'image/x-png'),
          'path' => sfConfig::get('sf_upload_dir').'/people',
        )));
      
      if ($this->getObject()->getImage() == null) {
          $this->setWidget('image', new sfWidgetFormInputFile());
      } else {
          $options = array(
              'file_src' => $this->getObject()->getImageWebPath(),
              'is_image' => true,
              'with_delete' => false,
              'delete_label' => true,
              'edit_mode' => true
              
              );
          $this->setWidget('image', new sfWidgetFormInputFileEditable($options));
      }
      $this->getValidator('image')->setOption('required', false);

        
        $this->setValidator('email', new sfValidatorEmail());
        $this->setValidator('website', new sfValidatorUrl());
        $this->getWidget('website')->setDefault('http://');
      
      // Prettify the categories
      $this->widgetSchema->setLabel('person_category_list', 'What are you?');
      $this->getWidget('person_category_list')->setOption('expanded', true);
      
      $this->getValidator('person_category_list')->setOption('required', true);
      $this->getValidator('person_category_list')->setOption('max', 3);
      $this->getValidator('person_category_list')->setOption('min', 1);
      $this->getValidator('person_category_list')->setMessage('required', 'You must choose at least one option.');
      
      // Setup the post validators with pretty messages
      $this->validatorSchema->setPostValidator(
        new sfValidatorAnd(array(
          new sfValidatorPropelUnique(array('model' => 'Person', 'column' => array('website')), array('invalid' => 'Sorry, that website has already been used.')),
          new sfValidatorPropelUnique(array('model' => 'Person', 'column' => array('email')), array('invalid' => 'Sorry, that email address has already been used.')),
        ))
      );
      
      $this->useFields(array('name', 'website', 'email', 'image', 'person_category_list'));
  }
}

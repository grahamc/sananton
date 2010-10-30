<?php
class ProjectBaseMessage extends Swift_Message
{
  public function __construct($subject, $body)
  {
      $body .= "\n--\n\nEmail from " . sfConfig::get('app_website_name')
            . ", get help at " . sfConfig::get('app_help_link');
            
    parent::__construct($subject, $body);
 
    // set all shared headers
    $this->setFrom(array(sfConfig::get('app_email_from') => sfConfig::get('app_email_name')));
  }
}
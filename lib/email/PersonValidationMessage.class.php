<?php
class PersonValidationMessage extends ProjectBaseMessage
{
  public function __construct(PersonHash $hash)
  {
      $body = 'Hey there, ' . $hash->getPerson() . "\n\n";
      $body .= "\tSeems someone signed up from this email account. ";
      $body .= "If this is innacurate, simply ignore this email. ";
      $body .= "However, if this is legitimate, click the following ";
      $body .= 'link to activate yourself: ' . sfConfig::get('app_base_url') . sfConfig::get('app_root_url') . 'validate/' . $hash;

      parent::__construct('Activate your listing on ' . sfConfig::get('app_website_name'), $body);      
      $this->setTo($hash->getPerson()->getEmail(), (string)$hash->getPerson());

  }
}
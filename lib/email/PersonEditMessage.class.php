<?php
class PersonEditMessage extends ProjectBaseMessage
{
  public function __construct(PersonHash $hash)
  {
      $body = 'Hey there, ' . $hash->getPerson() . "\n\n";
      $body .= "\tSeems someone requested to edit your account.";
      $body .= "If this is innacurate, simply ignore this email. ";
      $body .= "However, if this is legitimate, click the following ";
      $body .= 'link to edit yourself: ' . sfConfig::get('app_base_url') . sfConfig::get('app_root_url') . 'edit/' . $hash;

      parent::__construct('Edit your listing on ' . sfConfig::get('app_website_name'), $body);      
      $this->setTo($hash->getPerson()->getEmail(), (string)$hash->getPerson());

  }
}
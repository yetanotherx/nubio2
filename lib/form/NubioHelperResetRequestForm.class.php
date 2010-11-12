<?php

class NubioHelperResetRequestForm extends sfForm
{
  public function configure()
  {
    parent::configure();

    $this->setWidget('username_or_email',
      new sfWidgetFormInput(
        array(), array('maxlength' => 255)));

    $this->setValidator('username_or_email',
      new sfValidatorOr(
        array(
          new sfValidatorAnd(
            array(
              new sfValidatorString(array('required' => true,
                'trim' => true,
                'min_length' => 4,
                'max_length' => 255)),
              new sfValidatorDoctrineChoice(array('model' => 'sfGuardUser',
                'column' => 'username'), array("invalid" => "There is no such user.")))),
          new sfValidatorEmail(array('required' => true)))));
        
    $this->widgetSchema->setNameFormat('nubio_helper_reset_request[%s]');
    $this->widgetSchema->setFormFormatterName('list');
  }
}


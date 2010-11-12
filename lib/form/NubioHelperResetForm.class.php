<?php

class NubioHelperResetForm extends sfForm
{
  public function configure()
  {
    parent::configure();
	
	$this->widgetSchema['password'] = new sfWidgetFormInputPassword();
    $this->widgetSchema['password2'] = new sfWidgetFormInputPassword();
    
    $this->widgetSchema->setLabels(array(
      'password' => 'Choose NEW Password',
      'password2' => 'Confirm NEW Password'));
    
    $this->widgetSchema->setNameFormat('nubio_helper_reset[%s]');
    $this->widgetSchema->setFormFormatterName('list');
    
    $this->setValidator('password', new sfValidatorString(array(
      'required' => true,
      'trim' => true,
      'min_length' => 6,
      'max_length' => 128
    ), array(
      'min_length' => 'That password is too short. It must contain a minimum of %min_length% characters.')));
        
    $this->setValidator('password2', new sfValidatorString(array(
      'required' => true,
      'trim' => true,
      'min_length' => 6,
      'max_length' => 128
    ), array(
      'min_length' => 'That password is too short. It must contain a minimum of %min_length% characters.')));
      
    $this->validatorSchema->setPostValidator(
      new sfValidatorSchemaCompare(
        'password', sfValidatorSchemaCompare::EQUAL, 'password2',
        array(), array('invalid' => 'The passwords did not match.')));
  }
}


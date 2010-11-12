<?php

/**
 * NubioHelper form.
 *
 * @package    nubio
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class NubioHelperFormCreate extends BaseNubioHelperForm
{
  public function configure()
  {
  	$this->widgetSchema['first_name'] = new sfWidgetFormInputText();
    $this->widgetSchema['last_name'] = new sfWidgetFormInputText();
    $this->widgetSchema['email_address'] = new sfWidgetFormInputText();
    $this->widgetSchema['email_address2'] = new sfWidgetFormInputText();
    $this->widgetSchema['username'] = new sfWidgetFormInputText();
    $this->widgetSchema['password'] = new sfWidgetFormInputPassword();
    $this->widgetSchema['password2'] = new sfWidgetFormInputPassword();
    $this->widgetSchema['wikiname'] = new sfWidgetFormInputText();
    
    $this->validatorSchema['wikiname'] = new sfValidatorString(array('max_length' => 255));
    $this->validatorSchema['first_name'] = new sfValidatorString(array('max_length' => 255, 'required' => false, 'trim' => true));
    $this->validatorSchema['last_name'] = new sfValidatorString(array('max_length' => 255, 'required' => false, 'trim' => true));
	
	$this->setValidator('username',
      new sfValidatorAnd(array(
        new sfValidatorString(array(
          'required' => true,
          'trim' => true,
          'min_length' => 4,
          'max_length' => 255
        )),
        // Usernames should be safe to output without escaping and generally username-like.
        new sfValidatorRegex(array(
          'pattern' => '/^\w+$/'
        ), array('invalid' => 'Usernames must contain only letters, numbers and underscores.')),
        new sfValidatorDoctrineUnique(array(
          'model' => 'sfGuardUser',
          'column' => 'username'
        ), array('invalid' => 'There is already a user by that name. Choose another.'))
      ))
    );
    
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
	
	$this->setValidator('email_address', new sfValidatorAnd(array(
      new sfValidatorEmail(array('required' => true, 'trim' => true)),
      new sfValidatorString(array('required' => true, 'max_length' => 255)),
      new sfValidatorDoctrineUnique(array(
        'model' => 'sfGuardUser',
        'column' => 'email_address'
      ), array('invalid' => 'An account with that email address already exists. If you have forgotten your password, click "cancel", then "Reset My Password."'))
    )));
    
    $this->setValidator('email_address2', new sfValidatorEmail(array(
      'required' => true,
      'trim' => true
    )));
    
	$this->validatorSchema->setPostValidator(
		new sfValidatorAnd(array(
			new sfValidatorDoctrineUnique(array('model' => 'sfGuardUser', 'column' => array('username'))),
			new sfValidatorDoctrineUnique(array('model' => 'sfGuardUser', 'column' => array('email_address'))),
			new sfValidatorSchemaCompare(
				'password',
				sfValidatorSchemaCompare::EQUAL,
				'password2',
				array(),
				array('invalid' => 'The passwords did not match.')
			),
			new sfValidatorSchemaCompare(
				'email_address',
				sfValidatorSchemaCompare::EQUAL,
				'email_address2',
				array(),
				array('invalid' => 'The email addresses did not match.')
			)
		))
	);
    
    $this->useFields(array('username', 'wikiname', 'email_address', 'email_address2', 'password', 'password2', 'first_name', 'last_name'));
	
	$this->widgetSchema->setLabels(array(
		'wikiname' => 'Wikipedia username',
		'password2' => 'Confirm Password',
		'email_address2' => 'Confirm Email',
	));
	
	$this->widgetSchema->setHelp('first_name', 'Optional');
	$this->widgetSchema->setHelp('last_name', 'Optional');
  }
  
  protected function doSave($con = null)
  {
    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $this->updateObject();

    $this->getObject()->createSave($con, $this);

    // embedded forms
    $this->saveEmbeddedForms($con);
  }
}

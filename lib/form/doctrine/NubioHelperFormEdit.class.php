<?php

/**
 * NubioHelper form.
 *
 * @package    nubio
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class NubioHelperFormEdit extends BaseNubioHelperForm
{
  public function configure()
  {
  	$this->widgetSchema['first_name'] = new sfWidgetFormInputText();
    $this->widgetSchema['last_name'] = new sfWidgetFormInputText();
    $this->widgetSchema['username'] = new sfWidgetFormInputText();
    $this->widgetSchema['wikiname'] = new sfWidgetFormInputText();
    
    $this->validatorSchema['wikiname'] = new sfValidatorString(array('max_length' => 255));
    $this->validatorSchema['first_name'] = new sfValidatorString(array('max_length' => 255, 'required' => false, 'trim' => true));
    $this->validatorSchema['last_name'] = new sfValidatorString(array('max_length' => 255, 'required' => false, 'trim' => true));
	
	$this->widgetSchema['first_name']->setDefault($this->getObject()->obtainReference('sfGuardUser')->getFirstName());
	$this->widgetSchema['last_name']->setDefault($this->getObject()->obtainReference('sfGuardUser')->getLastName());
	$this->widgetSchema['username']->setDefault($this->getObject()->obtainReference('sfGuardUser')->getUsername());
	
	$this->setValidator('username',
      new sfValidatorAnd(array(
        new sfValidatorString(array(
          'required' => true,
          'trim' => true,
          'min_length' => 4,
          'max_length' => 128
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
    
    
	$this->validatorSchema->setPostValidator(
		new sfValidatorAnd(array(
			new sfValidatorDoctrineUnique(array('model' => 'sfGuardUser', 'column' => array('username'))),
		))
	);
    
    $this->useFields(array('username', 'wikiname', 'first_name', 'last_name'));
	
	$this->widgetSchema->setLabels(array(
		'wikiname' => 'Wikipedia username',
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

    $this->getObject()->editSave($con, $this);

    // embedded forms
    $this->saveEmbeddedForms($con);
  }
}

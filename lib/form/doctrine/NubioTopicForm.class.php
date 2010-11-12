<?php

/**
 * NubioTopic form.
 *
 * @package    nubio
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class NubioTopicForm extends BaseNubioTopicForm
{
  public function configure()
  {
	$this->widgetSchema['keywords'] = new sfWidgetFormInputText(); //Change keywords from textarea to text input
	
	$id = $this->getObject()->get('id');
	
	$doctrine = Doctrine_Core::getTable('NubioTopic')->getTopicFromID( $id );
	
	//Adding the Answer field
		$answer = null;
		if( !is_null( $id ) ) {
			$answer = $doctrine->obtainReference('NubioRevision')->getText();
		}
		$answer_widget = new sfWidgetFormTextarea();
		$answer_widget->setAttribute('rows', 10);
		$answer_widget->setAttribute('cols', 80);
		$this->setWidget( 'answer', $answer_widget->setDefault( $answer ) );
		$this->validatorSchema['answer'] = new sfValidatorString();
	
	$catchoices = Doctrine_Core::getTable('NubioCategory')->fetchFormArray();  	
  	$this->widgetSchema['category_id'] = new sfWidgetFormChoice(array(
  		'choices' => $catchoices,
	));
	$this->validatorSchema['category_id'] = new sfValidatorChoice(array(
  		'choices' => array_keys( $catchoices ),
	));
	
	$this->widgetSchema['comment'] = new sfWidgetFormInputText();
	$this->validatorSchema['comment'] = new sfValidatorString(array('max_length' => 255));
	
	
	$this->useFields(array('summary', 'answer', 'keywords', 'comment', 'category_id'));
	
	$this->widgetSchema->setLabels(array(
		'summary' => 'Question',
	));
	$this->widgetSchema->setHelp('keywords', 'Short, one-word keywords used to identify the question in search');
	
	
  }
  
  function doSave($con = null)
  {
    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $this->updateObject();

    $this->getObject()->revisionSave($con, $this);

    // embedded forms
    $this->saveEmbeddedForms($con);
  }
  
}

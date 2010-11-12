<?php

/**
 * NubioTopic form base class.
 *
 * @method NubioTopic getObject() Returns the current form's model object
 *
 * @package    nubio
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseNubioTopicForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'summary'     => new sfWidgetFormInputText(),
      'keywords'    => new sfWidgetFormTextarea(),
      'token'       => new sfWidgetFormInputText(),
      'revision_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('NubioRevision'), 'add_empty' => false)),
      'category_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('NubioCategory'), 'add_empty' => false)),
      'is_deleted'  => new sfWidgetFormInputText(),
      'created_at'  => new sfWidgetFormDateTime(),
      'updated_at'  => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'summary'     => new sfValidatorString(array('max_length' => 255)),
      'keywords'    => new sfValidatorString(array('required' => false)),
      'token'       => new sfValidatorString(array('max_length' => 255)),
      'revision_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('NubioRevision'))),
      'category_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('NubioCategory'))),
      'is_deleted'  => new sfValidatorInteger(array('required' => false)),
      'created_at'  => new sfValidatorDateTime(),
      'updated_at'  => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('nubio_topic[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'NubioTopic';
  }

}

<?php

/**
 * NubioRevision form base class.
 *
 * @method NubioRevision getObject() Returns the current form's model object
 *
 * @package    nubio
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseNubioRevisionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'helper_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('NubioHelper'), 'add_empty' => false)),
      'topic_id'   => new sfWidgetFormInputText(),
      'text'       => new sfWidgetFormTextarea(),
      'comment'    => new sfWidgetFormInputText(),
      'props'      => new sfWidgetFormTextarea(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'helper_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('NubioHelper'))),
      'topic_id'   => new sfValidatorInteger(array('required' => false)),
      'text'       => new sfValidatorString(),
      'comment'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'props'      => new sfValidatorString(array('required' => false)),
      'created_at' => new sfValidatorDateTime(),
      'updated_at' => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('nubio_revision[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'NubioRevision';
  }

}

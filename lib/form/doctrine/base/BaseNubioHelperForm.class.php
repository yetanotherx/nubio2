<?php

/**
 * NubioHelper form base class.
 *
 * @method NubioHelper getObject() Returns the current form's model object
 *
 * @package    nubio
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseNubioHelperForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'wikiname'     => new sfWidgetFormInputText(),
      'doctrine_uid' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('sfGuardUser'), 'add_empty' => false)),
      'is_blocked'   => new sfWidgetFormInputText(),
      'is_approved'  => new sfWidgetFormInputText(),
      'token'        => new sfWidgetFormInputText(),
      'created_at'   => new sfWidgetFormDateTime(),
      'updated_at'   => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'wikiname'     => new sfValidatorString(array('max_length' => 255)),
      'doctrine_uid' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('sfGuardUser'))),
      'is_blocked'   => new sfValidatorInteger(array('required' => false)),
      'is_approved'  => new sfValidatorInteger(array('required' => false)),
      'token'        => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'created_at'   => new sfValidatorDateTime(),
      'updated_at'   => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('nubio_helper[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'NubioHelper';
  }

}

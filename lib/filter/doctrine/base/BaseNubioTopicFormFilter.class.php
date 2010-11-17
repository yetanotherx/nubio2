<?php

/**
 * NubioTopic filter form base class.
 *
 * @package    nubio
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseNubioTopicFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'summary'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'keywords'    => new sfWidgetFormFilterInput(),
      'token'       => new sfWidgetFormFilterInput(),
      'revision_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('NubioRevision'), 'add_empty' => true)),
      'category_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('NubioCategory'), 'add_empty' => true)),
      'is_deleted'  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'created_at'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'summary'     => new sfValidatorPass(array('required' => false)),
      'keywords'    => new sfValidatorPass(array('required' => false)),
      'token'       => new sfValidatorPass(array('required' => false)),
      'revision_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('NubioRevision'), 'column' => 'id')),
      'category_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('NubioCategory'), 'column' => 'id')),
      'is_deleted'  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('nubio_topic_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'NubioTopic';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'summary'     => 'Text',
      'keywords'    => 'Text',
      'token'       => 'Text',
      'revision_id' => 'ForeignKey',
      'category_id' => 'ForeignKey',
      'is_deleted'  => 'Number',
      'created_at'  => 'Date',
      'updated_at'  => 'Date',
    );
  }
}

<?php

/**
 * BaseNubioCategory
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $name
 * @property Doctrine_Collection $NubioTopics
 * 
 * @method string              getName()        Returns the current record's "name" value
 * @method Doctrine_Collection getNubioTopics() Returns the current record's "NubioTopics" collection
 * @method NubioCategory       setName()        Sets the current record's "name" value
 * @method NubioCategory       setNubioTopics() Sets the current record's "NubioTopics" collection
 * 
 * @package    nubio
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseNubioCategory extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('nubio_category');
        $this->hasColumn('name', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'unique' => true,
             'length' => 255,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('NubioTopic as NubioTopics', array(
             'local' => 'id',
             'foreign' => 'category_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $sluggable0 = new Doctrine_Template_Sluggable(array(
             'fields' => 
             array(
              0 => 'name',
             ),
             ));
        $this->actAs($timestampable0);
        $this->actAs($sluggable0);
    }
}
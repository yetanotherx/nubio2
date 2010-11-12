<?php

/**
 * BaseNubioTopic
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $summary
 * @property blob $keywords
 * @property string $token
 * @property integer $revision_id
 * @property integer $category_id
 * @property integer $is_deleted
 * @property NubioCategory $NubioCategory
 * @property NubioRevision $NubioRevision
 * 
 * @method string        getSummary()       Returns the current record's "summary" value
 * @method blob          getKeywords()      Returns the current record's "keywords" value
 * @method string        getToken()         Returns the current record's "token" value
 * @method integer       getRevisionId()    Returns the current record's "revision_id" value
 * @method integer       getCategoryId()    Returns the current record's "category_id" value
 * @method integer       getIsDeleted()     Returns the current record's "is_deleted" value
 * @method NubioCategory getNubioCategory() Returns the current record's "NubioCategory" value
 * @method NubioRevision getNubioRevision() Returns the current record's "NubioRevision" value
 * @method NubioTopic    setSummary()       Sets the current record's "summary" value
 * @method NubioTopic    setKeywords()      Sets the current record's "keywords" value
 * @method NubioTopic    setToken()         Sets the current record's "token" value
 * @method NubioTopic    setRevisionId()    Sets the current record's "revision_id" value
 * @method NubioTopic    setCategoryId()    Sets the current record's "category_id" value
 * @method NubioTopic    setIsDeleted()     Sets the current record's "is_deleted" value
 * @method NubioTopic    setNubioCategory() Sets the current record's "NubioCategory" value
 * @method NubioTopic    setNubioRevision() Sets the current record's "NubioRevision" value
 * 
 * @package    nubio
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseNubioTopic extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('nubio_topic');
        $this->hasColumn('summary', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('keywords', 'blob', null, array(
             'type' => 'blob',
             'length' => '',
             ));
        $this->hasColumn('token', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('revision_id', 'integer', 8, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => 8,
             ));
        $this->hasColumn('category_id', 'integer', 8, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => 8,
             ));
        $this->hasColumn('is_deleted', 'integer', 1, array(
             'type' => 'integer',
             'notnull' => true,
             'default' => 0,
             'length' => 1,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('NubioCategory', array(
             'local' => 'category_id',
             'foreign' => 'id'));

        $this->hasOne('NubioRevision', array(
             'local' => 'revision_id',
             'foreign' => 'id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}
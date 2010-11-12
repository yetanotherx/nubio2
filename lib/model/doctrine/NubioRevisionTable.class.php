<?php

/**
 * NubioRevisionTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class NubioRevisionTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object NubioRevisionTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('NubioRevision');
    }
    
    public static function routingQuery( $query ) {
    	return $query
	      ->innerJoin('a.NubioHelper h')
	      ->innerJoin('h.sfGuardUser u ON h.id = a.helper_id')
	      ->execute();
    }
    
    public static function createBaseQuery() {
    	return self::getInstance()
	      ->createQuery('r')
	      ->innerJoin('r.NubioHelper h')
	      ->innerJoin('h.sfGuardUser u ON h.id = r.helper_id');
    }
    
    public function setTopicId( $rev_id, $topic_id ) {
    	$user = self::getInstance()->find($rev_id);
		$user->topic_id = $topic_id;
		return $user->save();
    }
    
    public function getRevisionFromID( $id ) {
    	return self::createBaseQuery()->where( 'r.id = ?', $id )->fetchOne();
    }
    
    public function getRevisionList() {
    	return self::createBaseQuery()->execute();
    }
}
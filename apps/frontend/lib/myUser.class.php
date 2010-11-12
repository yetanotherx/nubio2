<?php

class myUser extends sfGuardSecurityUser
{
	public function addTopicToHistory(NubioTopic $topic) {
		$ids = $this->getAttribute('topic_history', array());
		
		if (!in_array($topic->getId(), $ids)) {
			array_unshift($ids, $topic->getId());
		
			$this->setAttribute('topic_history', array_slice($ids, 0, sfConfig::get('app_max_sidebar_topics')));
		}
	}
	
	public function getTopicHistory() {
	
		$ids = $this->getAttribute('topic_history', array());
		if (!empty($ids)) {
	  		$arr = Doctrine_Core::getTable('NubioTopic')
	    		->createQuery('a')
	    		->whereIn('a.id', $ids)
	    		->fetchArray();
	    	
	    	
	    	$arr2 = array();
	    	foreach( $arr as $key => $val ) {
	    		$key_old = array_search( $val['id'], $ids );
	    		if( $key_old !== false ) {
	    			$arr2[$key_old] = $val;
	    		}
	    	}
	    	ksort($arr2);
	    	
	    	return $arr2;
		}
	
		return array();
	}
	
	public function resetTopicHistory() {
    	$this->getAttributeHolder()->remove('topic_history');
	}
	
	public function getId() {
		return Doctrine_Core::getTable('sfGuardUser')
			->createQuery('g')
			->where('g.username = ?', $this->getUsername() )
			->fetchOne()
			->getId();
	}
	
}

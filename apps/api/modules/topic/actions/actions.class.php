<?php

/**
 * topic actions.
 *
 * @package    nubio
 * @subpackage topic
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class topicActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    //$this->forward('default', 'module');
    $arr = Doctrine_Core::getTable('NubioTopic')->createBaseQuery()->orderBy('t.id ASC')->fetchArray();
    
    $arr = NubioApi::topicList( $arr );
    
    NubioApi::apiPrint( $arr, $request );
  }
  
  public function executeRandom(sfWebRequest $request)
  {
    //$this->forward('default', 'module');
    $id = Nubio::getRandTopicId();
    $request->setParameter( 'id', $id );
    
    $this->executeShow($request);
  }
  
  public function executeShow(sfWebRequest $request)
  {
    //$this->forward('default', 'module');
    $arr = Doctrine::getTable('NubioTopic')->createBaseQuery()->where( 't.id = ?', $request->getParameter('id',-1) )->fetchArray();
    
    if( !count($arr) ) {
    	NubioApi::apiPrint( array(), $request );
    }
    
    $arr = NubioApi::topicList( $arr );
    
    NubioApi::apiPrint( $arr[0], $request );
  }
  
  public function executeHistory(sfWebRequest $request) {
  	$arr = Doctrine_Core::getTable('NubioRevision')
			->createBaseQuery()
			->where( 'r.topic_id = ?', $request->getParameter('id',-1) )
			->orderBy( 'r.created_at DESC' )
			->fetchArray();
    
    if( !count($arr) ) {
    	NubioApi::apiPrint( array(), $request );
    }
    
    $arr = NubioApi::revisionList( $arr );
    
    NubioApi::apiPrint( $arr, $request );
  }
  
  public function executeSearch(sfWebRequest $request) {
  	$query = $request->getParameter('query');
 	if( is_null( $query ) ) {
 		$arr = array();
 	}
 	else {
 		$arr = Doctrine_Core::getTable('NubioTopic')->getForLuceneQueryBase($query)->fetchArray();
 		$arr = NubioApi::topicList( $arr );
    }
    
    NubioApi::apiPrint( $arr, $request );
 	
  }
  
  public function executeHelp(sfWebRequest $request) {
  	$arr = array(
  		'_element' => 'r',
  		'foo' => 'bar',
  		345,
  		'rjg' => 235,
  		'jhd' => array(
  			'foo' => 'bar'
  		)
  	);
  	
  	NubioApi::apiPrint( $arr, $request );
  }
  
}

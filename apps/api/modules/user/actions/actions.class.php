<?php

/**
 * user actions.
 *
 * @package    nubio
 * @subpackage user
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class userActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $arr = Doctrine::getTable('NubioHelper')->createBaseQuery()->fetchArray();
    
    $arr = NubioApi::helperList( $arr );
    
    NubioApi::apiPrint( $arr, $request );
  }
  
  public function executeShow(sfWebRequest $request)
  {
    $arr = Doctrine::getTable('NubioHelper')->createBaseQuery()->where( 'h.id = ?', $request->getParameter('id',-1) )->fetchArray();
    
    if( !count($arr) ) {
    	NubioApi::apiPrint( array(), $request );
    }
    
    $arr = NubioApi::helperList( $arr );
    
    NubioApi::apiPrint( $arr[0], $request );
  }
  
  public function executeContribs(sfWebRequest $request)
  {
    $arr = Doctrine_Core::getTable('NubioRevision')
			->createBaseQuery()
			->where( 'h.id = ?', $request->getParameter( 'id', -1 ) )
			->fetchArray();
    
    if( !count($arr) ) {
    	NubioApi::apiPrint( array(), $request );
    }
    
    $arr = NubioApi::revisionList( $arr );
    
    NubioApi::apiPrint( $arr, $request );
    
  }
}

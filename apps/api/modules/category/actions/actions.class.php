<?php

/**
 * category actions.
 *
 * @package    nubio
 * @subpackage category
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class categoryActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $arr = Doctrine_Core::getTable('NubioCategory')->createQuery('c')->orderBy('c.id ASC')->fetchArray();
    
    $arr = NubioApi::categoryList( $arr );
    
    NubioApi::apiPrint( $arr, $request );
  }
  
  public function executeShow(sfWebRequest $request)
  {
    
	$arr = Doctrine::getTable('NubioCategory')->createQuery('c')->where( 'c.id = ?', $request->getParameter('id',-1) )->fetchArray();
    
    if( !count($arr) ) {
    	var_dump($arr);
    	NubioApi::apiPrint( array(), $request );
    }
    
    $arr = NubioApi::categoryList( $arr );
    
    NubioApi::apiPrint( $arr[0], $request );

  }
}

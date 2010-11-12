<?php

/**
 * revision actions.
 *
 * @package    nubio
 * @subpackage revision
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class revisionActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeShow(sfWebRequest $request)
  {
    $arr = Doctrine::getTable('NubioRevision')->createBaseQuery()->where( 'r.id = ?', $request->getParameter('id',-1) )->fetchArray();
    
    if( !count($arr) ) {
    	NubioApi::apiPrint( array(), $request );
    }
    
    $arr = NubioApi::revisionList( $arr );
    
    NubioApi::apiPrint( $arr[0], $request );
  }
  
  public function executeIndex(sfWebRequest $request)
  {
    $arr = Doctrine::getTable('NubioRevision')->createBaseQuery()->fetchArray();
    
    $arr = NubioApi::revisionList( $arr );
    
    NubioApi::apiPrint( $arr, $request );
  }
  
  public function executeDiff(sfWebRequest $request)
  {
    $old = Doctrine::getTable('NubioRevision')->createBaseQuery()->where( 'r.id = ?', $request->getParameter('oldid',-1) )->fetchArray();
    $new = Doctrine::getTable('NubioRevision')->createBaseQuery()->where( 'r.id = ?', $request->getParameter('id',-1) )->fetchArray();
    
    if( !count( $old ) ) $old = array( 0 => array() );
    if( !count( $new ) ) $new = array( 0 => array() );
    
    $type = $request->getParameter('type', 'unified');
    if( !in_array( $type, array( 'unified', 'inline', 'context',  'threeway', 'dualview' ) ) ) $type = 'unified';
    
    $diff_text = Diff::load( $type, @$old[0]['text'], @$new[0]['text'] );
    
    if( is_array( $diff_text ) ) {
    	$diff_text = array(
    		'removed' => array( '*' => $diff_text[0] ),
    		'added' => array( '*' => $diff_text[1] ) 
    	);
    	$diff = $diff_text;
    }
    else {
    	$diff = array( '*' => $diff_text );
    }
    
    if( count( $old[0] ) ) $old = NubioApi::revisionList( $old );
    if( count( $new[0] ) ) $new = NubioApi::revisionList( $new );
    
    $arr = array(
    	'old' => $old[0],
    	'new' => $new[0],
    	'diff' => $diff
    );

    NubioApi::apiPrint( $arr, $request );

  }
  
}

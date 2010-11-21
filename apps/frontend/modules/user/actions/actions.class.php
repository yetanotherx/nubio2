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
    $this->nubio_helpers = Doctrine::getTable('NubioHelper')->getHelperList();
    
    $this->helper_pager = new sfDoctrinePager(
		'NubioHelper',
		sfConfig::get('app_max_users_on_user')
	);
	
	$query = Doctrine_Core::getTable('NubioHelper')->createBaseQuery();
	if( !is_null( $request->getParameter( 'onlyunapproved' ) ) ) {
	
		if( !$this->getUser()->isSuperAdmin() ) {
			return 'NotAdmin';
		}
		
		$query = Doctrine_Core::getTable('NubioHelper')->getUnapprovedList();
		
	}
	
	$this->helper_pager->setQuery( $query );
	$this->helper_pager->setPage( $request->getParameter( 'page', 1 ) );
	$this->helper_pager->init();
  }
  
  public function executeShow(sfWebRequest $request)
  {
    $this->nubio_helper = $this->getRoute()->getObject();
  }
  
  public function executeBlock(sfWebRequest $request)
  {
    $this->forward404Unless($this->getUser()->isSuperAdmin());

    $this->nubio_helper = $this->getRoute()->getObject();
    
    $this->nubio_helper->setIsBlocked(true);
    $this->nubio_helper->save();
  }
  
  public function executeContribs(sfWebRequest $request)
  {
    $this->nubio_helper = $this->getRoute()->getObject();
    
    $this->revision_pager = new sfDoctrinePager(
		'NubioRevision',
		sfConfig::get('app_max_revisions_per_user_on_contribs')
	);
	
	$this->revision_pager->setQuery( $this->nubio_helper->getContributionListQueryFromID( $this->nubio_helper->getId() )->orderBy( 'r.created_at DESC' ) );
	$this->revision_pager->setPage( $request->getParameter( 'page', 1 ) );
	$this->revision_pager->init();
  }
}

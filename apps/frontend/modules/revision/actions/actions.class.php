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
    $this->nubio_revision = $this->getRoute()->getObject();
  }
  
  public function executeIndex(sfWebRequest $request)
  {
    $this->nubio_revisions = Doctrine::getTable('NubioRevision')->getRevisionList();
    
    $this->revision_pager = new sfDoctrinePager(
		'NubioRevision',
		sfConfig::get('app_max_revisions_on_revision')
	);
	
	$this->revision_pager->setQuery( Doctrine_Core::getTable('NubioRevision')->createBaseQuery()->orderBy( 'r.created_at DESC' ) );
	$this->revision_pager->setPage( $request->getParameter( 'page', 1 ) );
	$this->revision_pager->init();
  }
  
  public function executeDiff(sfWebRequest $request)
  {
    $this->new_revision = $this->getRoute()->getObject();
    $this->old_revision = Doctrine::getTable('NubioRevision')->getRevisionFromID($request->getParameter('oldid'));
    $this->forward404Unless($this->old_revision);
    

  }
}

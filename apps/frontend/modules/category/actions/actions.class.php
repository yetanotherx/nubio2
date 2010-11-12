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
  public function executeShow(sfWebRequest $request)
  {
    $this->nubio_category = $this->getRoute()->getObject();
    
    $this->category_pager = new sfDoctrinePager(
		'NubioTopic',
		sfConfig::get('app_max_topics_per_category_on_category')
	);
	
	$this->category_pager->setQuery( $this->nubio_category->getCategoryQueryFromID( $this->nubio_category->getId() ) );
	$this->category_pager->setPage( $request->getParameter( 'page', 1 ) );
	$this->category_pager->init();

  }
  
  public function executeIndex(sfWebRequest $request)
  {
    $this->nubio_categories = Doctrine::getTable('NubioCategory')->getCategoryList();
    
    $this->category_pager = new sfDoctrinePager(
		'NubioCategory',
		sfConfig::get('app_max_categories_on_category_index')
	);
	
	$this->category_pager->setQuery( Doctrine_Core::getTable('NubioCategory')->createQuery('c') );
	$this->category_pager->setPage( $request->getParameter( 'page', 1 ) );
	$this->category_pager->init();
  }
}

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
  public function executeIndex(sfWebRequest $request)
  {
	
    $this->category_pager = new sfDoctrinePager(
		'NubioCategory',
		sfConfig::get('app_max_categories_on_homepage')
	);
	
	$this->category_pager->setQuery( Doctrine_Core::getTable('NubioCategory')->createQuery('c') );
	$this->category_pager->setPage( $request->getParameter( 'page', 1 ) );
	$this->category_pager->init();
  }

  public function executeShow(sfWebRequest $request)
  {
    
	$this->nubio_topic = $this->getRoute()->getObject();
	$this->getUser()->addTopicToHistory($this->nubio_topic); //Bug, Bumps off chronologically

  }
  
  public function executeHistory(sfWebRequest $request)
  {
    
	$this->nubio_topic = $this->getRoute()->getObject();
	
	$this->revision_pager = new sfDoctrinePager(
		'NubioRevision',
		sfConfig::get('app_max_revisions_on_history')
	);
	
	$this->revision_pager->setQuery( $this->nubio_topic->getHistoryListQueryFromID( $this->nubio_topic->getId() )->orderBy( 'r.created_at DESC' ) );
	$this->revision_pager->setPage( $request->getParameter( 'page', 1 ) );
	$this->revision_pager->init();

  }
  
  public function executeSource(sfWebRequest $request)
  {
	$this->nubio_topic = $this->getRoute()->getObject();
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new NubioTopicForm(
    	null, 
    	array(
    		'userID' => $this->getUser()->getGuardUser()->getId(),
    		'currentVals' => $this->getRoute()->getObject()->toArray()
    	)
    );
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->form = new NubioTopicForm(
    	null, 
    	array(
    		'userID' => $this->getUser()->getGuardUser()->getId(),
    		'currentVals' => $this->getRoute()->getObject()->toArray()
    	)
    );
    
    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request, $disabled = false)
  {
  	
  	$id = 0;
  	if( !$disabled ) $id = $this->getUser()->getGuardUser()->getId();
   
    $this->form = new NubioTopicForm(
    	$this->getRoute()->getObject(), 
    	array(
    		'userID' => $id,
    		'currentVals' => $this->getRoute()->getObject()->toArray(),
    		'disabled' => $disabled
    	)
    );
    
  }

  public function executeUpdate(sfWebRequest $request)
  {
  	$this->form = new NubioTopicForm(
    	$this->getRoute()->getObject(), 
    	array(
    		'userID' => $this->getUser()->getGuardUser()->getId(),
    		'currentVals' => $this->getRoute()->getObject()->toArray()
    	)
    );

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    //$request->checkCSRFProtection();

    $this->forward404();//Unless($nubio_topic = Doctrine_Core::getTable('NubioTopic')->find(array($request->getParameter('id'))), sprintf('Object nubio_topic does not exist (%s).', $request->getParameter('id')));
    //$nubio_topic->delete();

    //$this->redirect('topic/index');
  }
  
  public function executeRandom(sfWebRequest $request) {
  	$id = Nubio::getRandTopicId();
  	
  	$this->redirect( 'topic/show?id=' . $id );
  }
  
  public function executeSearch(sfWebRequest $request)
  {
    $this->forwardUnless($query = $request->getParameter('query'), 'topic', 'index');
 
    $this->nubio_topics = Doctrine_Core::getTable('NubioTopic')->getForLuceneQuery($query);
    
    if ($request->isXmlHttpRequest()) {
		if ('*' == $query || !$this->nubio_topics) {
			return $this->renderText('No results.');
		}

		return $this->renderPartial('topic/list', array('nubio_topics' => $this->nubio_topics));
	}

  }


  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $nubio_topic = $form->save();

      $this->redirect('topic/show?id=' . $nubio_topic->getId());
    }
  }
}

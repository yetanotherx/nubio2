<?php

class acWebDebugPanelAPI extends sfWebDebugPanel
{
  public function getTitle()
  {
    return 'API';
  }
  
  public function getPanelTitle() {
  	return 'API';
  }
  
  public function getTitleUrl() {
  	return 'http://www.symfony-project.org/api/1_4/';
  }
 
  public function getPanelContent()
  {
    return;
  }
  
  public static function listenToLoadDebugWebPanelEvent(sfEvent $event)
	{
	  $event->getSubject()->setPanel(
	    'API',
	    new self($event->getSubject())
	  );
	}
}
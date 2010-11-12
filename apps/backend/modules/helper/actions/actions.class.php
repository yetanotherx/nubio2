<?php

require_once dirname(__FILE__).'/../lib/helperGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/helperGeneratorHelper.class.php';

/**
 * helper actions.
 *
 * @package    nubio
 * @subpackage helper
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class helperActions extends autoHelperActions
{
	public function executeBatchApprove(sfWebRequest $request)
  {
    $ids = $request->getParameter('ids');
 
    $q = Doctrine_Core::getTable('NubioHelper')
    	->createBaseQuery()
      	->whereIn('h.id', $ids);
 	
 	$request = sfContext::getInstance()->getRequest();
	$root = $request->getRelativeUrlRoot();
	$source = 'http://'.$request->getHost().$root;

    foreach ($q->execute() as $helper)
    {
      $helper->setIsApproved(true);
      $helper->save();
	  $message = $this->getMailer()->compose(
      	array('nubio@toolserver.org' => 'Nubio'),
      	$helper->obtainReference('sfGuardUser')->getEmailAddress(),
      	'Nubio account approved',
      <<<EOF
Your Nubio account has been approved! 

You can return to the main site and log in at the following URL:

{$source}

EOF
    );
 
      $this->getMailer()->send($message);
    
    }
 
    $this->getUser()->setFlash('notice', 'The selected users have been approved.');
 
    $this->redirect('nubio_helper');
  }
  
  public function executeListApprove(sfWebRequest $request)
  {
    $helper = $this->getRoute()->getObject();
    $helper->setIsApproved(true);
    $helper->save();
    
    $helper = Doctrine_Core::getTable( 'NubioHelper' ) 
    	->createBaseQuery()
    	->where( 'h.id = ?', $helper->getId() )
    	->fetchArray();
    
    $request = sfContext::getInstance()->getRequest();
	$root = $request->getRelativeUrlRoot();
	$source = 'http://'.$request->getHost().$root;

    $message = $this->getMailer()->compose(
      	array('nubio@toolserver.org' => 'Nubio'),
      	$helper['sfGuardUser']['email_address'],
      	'Nubio account approved',
      <<<EOF
Your Nubio account has been approved! 

You can return to the main site and log in at the following URL:

{$source}

EOF
    );
 
    $this->getMailer()->send($message);
 
    $this->getUser()->setFlash('notice', 'The selected users have been approved.');
 
    $this->redirect('nubio_helper');
  }


}

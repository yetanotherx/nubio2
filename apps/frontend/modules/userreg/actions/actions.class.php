<?php

/**
 * userreg actions.
 *
 * @package    nubio
 * @subpackage userreg
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class userregActions extends sfActions
{

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new NubioHelperFormCreate();
  }
  
  public function executeApprove(sfWebRequest $request)
  {
    $this->forward404Unless($this->getUser()->isSuperAdmin());

    $this->nubio_helper = $this->getRoute()->getObject();
    
    $this->nubio_helper->setIsApproved(true);
    $this->nubio_helper->save();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new NubioHelperFormCreate();
	
    $this->processForm($request, $this->form);
    
    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
  	
  	if( $this->getUser()->isAnonymous() ) return 'Login';
  	
  	$nubio_helper = Doctrine_Core::getTable('NubioHelper')
  		->createBaseQuery()
  		->where( 'h.id = ?', $request->getParameter('id') )
  		->fetchOne();
  	$this->forward404Unless($nubio_helper, sprintf('Object nubio_helper does not exist (%s).', $request->getParameter('id')));
    
  	if( $this->getUser()->getId() != $nubio_helper->getId() ) return 'WrongUser';
    
    $this->form = new NubioHelperFormEdit(
    	$nubio_helper, 
    	array(
    		'currentVals' => $nubio_helper->toArray(),
    	)
    );
	
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $nubio_helper = Doctrine_Core::getTable('NubioHelper')
  		->createBaseQuery()
  		->where( 'h.id = ?', $request->getParameter('id') )
  		->fetchOne();
  	$this->forward404Unless($nubio_helper, sprintf('Object nubio_helper does not exist (%s).', $request->getParameter('id')));
  	
    $this->form = new NubioHelperFormEdit(
    	$nubio_helper, 
    	array(
    		'currentVals' => $nubio_helper->toArray(),
    	)
    );
    
    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
    $this->redirect('@homepage');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404();//Unless($nubio_helper = Doctrine_Core::getTable('NubioHelper')->find(array($request->getParameter('id'))), sprintf('Object nubio_helper does not exist (%s).', $request->getParameter('id')));
    //$nubio_helper->delete();

    $this->redirect('userreg/index');
  }
  
  public function executeConfirm(sfWebRequest $request) {
	$token = $request->getParameter('validate');
	
	$user = Doctrine_Core::getTable('NubioHelper')->
		createQuery('h')->
		where('h.token = ?', $token)->
		fetchOne();
	
	if (!$user) {
		return 'Invalid';
	}
	
	$type = self::getTokenType($token);
	
	if ( !strlen( $token ) ) {
		return 'Invalid';
	}
	
	//$user->setToken(null);
	//$user->save();
	
	if ($type == 'New') {
		$doctrine = Doctrine_Core::getTable('sfGuardUser')->
			createQuery('h')->
			where('h.id = ?', $user->getDoctrineUid())->
			fetchOne();
		$doctrine->setIsActive(true);  
		$doctrine->save();
		$this->getUser()->signIn($doctrine);
	}
	if ($type == 'Reset')
    {
      $this->getUser()->setAttribute('guard_user_id', $user->getDoctrineUid());
      return $this->redirect('NubioUserreg/reset');
    }
  }
  
  public function executeReset(sfRequest $request)
  {
    $this->form = new NubioHelperResetForm();
    if ($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter('nubio_helper_reset'));
      if ($this->form->isValid())
      {
        $this->id = $this->getUser()->getAttribute('guard_user_id', false);
        $this->forward404Unless($this->id);
        
        $this->sfGuardUser = Doctrine::getTable('sfGuardUser')->find($this->id);
        $this->forward404Unless($this->sfGuardUser);
        
        $sfGuardUser = $this->sfGuardUser;
        $sfGuardUser->setPassword($this->form->getValue('password'));
        $sfGuardUser->save();
        
        $this->getUser()->signIn($sfGuardUser);
        $this->getUser()->setAttribute('guard_user_id', null);
        
        return 'After';
      }
    }
  }
  
  static private function getTokenType($validate)
  {
    $t = substr($validate, 0, 1);  
    if ($t == 'n')
    {
      return 'New';
    } 
    elseif ($t == 'r')
    {
      return 'Reset';
    }
    else
    {
      return sfView::NONE;
    }
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $nubio_helper = $form->save();

      $this->redirect('@homepage');
    }
  }
  
  public function executeResetRequest(sfRequest $request)
  {
    $user = $this->getUser();
    if ($user->isAuthenticated())
    {
      	$nubio_helper = Doctrine_Core::getTable('NubioHelper')
  			->createBaseQuery()
  			->where( 'g.id = ?', $user->getGuardUser()->getId() )
  			->fetchOne();
  		
  		$this->forward404Unless($nubio_helper, sprintf('Object nubio_helper does not exist (%s).', $user->getGuardUser()->getId() ) );
    
  		return $this->resetRequestBody($nubio_helper);
    }
    else
    {
      $this->form = new NubioHelperResetRequestForm();
      if ($request->isMethod('post'))
      {
        $this->form->bind($request->getParameter('nubio_helper_reset_request'));
        if ($this->form->isValid())
        {
          
          $username_or_email = $this->form->getValue('username_or_email');
          if (strpos($username_or_email, '@') !== false)
          {
            $user = Doctrine::getTable('NubioHelper')->getFromDoctrineEmail( $username_or_email );
            
          }
          else
          {
            $user = Doctrine::getTable('NubioHelper')->getFromDoctrineUsername( $username_or_email );
          }
          return $this->resetRequestBody($user);
        }
      }
    }
  }
  
  public function resetRequestBody($user)
  {
    if (!$user)
    {
      return 'NoSuchUser';
    }
    $this->forward404Unless($user);
    
    if (!$user->obtainReference('sfGuardUser')->getIsActive())
    {
      $type = $this->getTokenType($user->getToken());
      if ($type === 'New')
      {
        try 
        {
          $message = Nubio::getVerificationEmail( array( 'email_address' => $user->obtainReference('sfGuardUser')->getEmailAddress() ), $user);
          sfContext::getInstance()->getMailer()->send($message);
        }
        catch (Exception $e)
        {
          return 'Error';
        }
        return 'Unverified';
      }
      elseif ($type === 'Reset')
      {
      }
      else
      {
        return 'Error';
      }
    }
    
	$user->setToken( md5( serialize( array() ) . $user->doctrine_uid . serialize( $user->toArray() ) ) );
	$user->setToken( 'r' . substr( $user->token, 0, 31 ) );
    $user->save();
    
    try
    {
      $message = sfContext::getInstance()->getMailer()->compose(
      		array('nubio@toolserver.org' => 'Nubio'),
      		$user->obtainReference('sfGuardUser')->getEmailAddress(),
      		'Nubio password reset request',
      		<<<EOF
We have received your request to recover your username and possibly your password on:

http://{$_SERVER['SERVER_NAME']}{$_SERVER['SCRIPT_NAME']}

Your username is: {$user->obtainReference('sfGuardUser')->getUsername()}

If you have lost your password or wish to reset it, click on the link that follows:

http://{$_SERVER['SERVER_NAME']}{$_SERVER['SCRIPT_NAME']}/userreg/confirm/{$user->token}

You will then be prompted for the new password you wish to use.

Your password will NOT be changed unless you click on the
link above and complete the form.

Thank you!
-Nubio
EOF
    	);
    	sfContext::getInstance()->getMailer()->send($message);
    } catch (Exception $e)
    {
      return 'Error';
    }
    
    return 'After';
  }
  
  
}

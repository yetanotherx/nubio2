<?php

class NubioTestFunctional extends sfTestFunctional
{
  public function loadData()
  {
  	
  	$this->info( 'Cleaning database...' );
  	shell_exec( 'php ' . sfConfig::get('sf_root_dir') . '/symfony doctrine:build --all --no-confirmation --env=test' );
  	$this->info( 'Done' );
  	
    Doctrine_Core::loadData(sfConfig::get('sf_test_dir').'/fixtures');
 
    return $this;
  }
  
  function signin($username, $password) {
  	//sfConfig::set( 'nubio_api_csrf', null );
  	//sfConfig::set( 'nubio_backend_csrf', null );
  	//sfConfig::set( 'nubio_frontend_csrf', null );
  	
  	return $this->info(sprintf('Signin user using username "%s" and password "%s"', $username, $password))->
    
    post('/sfGuardAuth/signin', array(
    	'signin' => array(
    		'username' => $username, 
    		'password' => $password,
    		'_csrf_token' => '0123456789abcdef0123456789abcdef' 
    	)
    ))->
	
	with('response')->begin()->
		debug()->
		isRedirected()->
	end();
  }
}
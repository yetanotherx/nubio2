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
}
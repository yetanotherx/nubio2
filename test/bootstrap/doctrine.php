<?php

include(dirname(__FILE__).'/unit.php');
 
$configuration = ProjectConfiguration::getApplicationConfiguration( 'frontend', 'test', true);
 
new sfDatabaseManager($configuration);

echo "> Cleaning database...\n";
shell_exec( 'php ' . sfConfig::get('sf_root_dir') . '/symfony doctrine:build --all --no-confirmation --env=test' );
echo "> Done.\n";

Doctrine_Core::loadData(sfConfig::get('sf_test_dir').'/fixtures');
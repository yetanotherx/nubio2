<?php

/*
 * This file is part of the symfony package.
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 *
 * @package    symfony
 * @subpackage plugin
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfGuardValidatorUser.class.php 25546 2009-12-17 23:27:55Z Jonathan.Wage $
 */
class sfGuardValidatorUserExt extends sfGuardValidatorUser
{
  public function configure($options = array(), $messages = array())
  {
    parent::configure( $options, $messages );
    
    $this->addMessage('notapproved', 'Your account has not yet been approved. Please wait for an administrator to approve your account. If you have been waiting more than a few days, please ask an admin in the #wikipedia-en-help IRC channel on irc.freenode.net.');
    $this->addMessage('blocked', 'Your account has been blocked from editing. Please ask an administrator in the #wikipedia-en-help IRC channel on irc.freenode.net if you have questions.');
  }

  protected function doClean($values)
  {
    
    $username = isset($values[$this->getOption('username_field')]) ? $values[$this->getOption('username_field')] : '';
    if( $username ) {
    	$user = Doctrine_Core::getTable('NubioHelper')->getFromDoctrineUsername( $username );
    	if( !$user->getIsApproved() ) {
    		throw new sfValidatorError($this, 'notapproved');
    	}
    	if( $user->getIsBlocked() ) {
    		throw new sfValidatorError($this, 'blocked');
    	}
    }
    
    return parent::doClean($values);
    
  }
}

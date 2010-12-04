<?php

class myUser extends sfGuardSecurityUser
{
	public function getId() {
		return Doctrine_Core::getTable('sfGuardUser')
			->createQuery('g')
			->where('g.username = ?', $this->getUsername() )
			->fetchOne()
			->getId();
	}
}

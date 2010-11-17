<?php

class NubioFauxRequest {
	
	function setParameter( $param, $val ) {
		$this->$param = $val;
	}
	
	function getParameter( $param, $default = null ) {
		return isset( $this->$param ) ? $this->$param : $default;
	}
	
	function getRequestParameters() {
		return get_object_vars($this);
	}
	
}
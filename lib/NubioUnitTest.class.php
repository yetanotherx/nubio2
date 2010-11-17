<?php

class NubioUnitTest extends lime_test {
	function is_ignore_nl($exp1, $exp2, $message = '') {
    	return $this->is(str_replace("\n",'',$exp1), str_replace("\n",'',$exp2), $message);
    }

}

class NubioLimeOutput
{
  public function __construct($force_colors = false, $base_dir = null)
  {}

  public function diag()
  {}

  public function comment($message)
  {}

  public function info($message)
  {}

  public function error($message, $file = null, $line = null, $traces = array())
  {}

  protected function print_trace($method = null, $file = null, $line = null)
  {}

  public function echoln($message, $colorizer_parameter = null, $colorize = true)
  {}

  public function green_bar($message)
  {}

  public function red_bar($message)
  {}

  protected function strip_base_dir($text)
  {}
}
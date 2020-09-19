<?php
namespace PHPCommander;

class InvalidFlgException extends \Exception {
	public function __construct(string $flg, \Exception $previous=null) {
		$message = "Flg key [{ $flg }] must be start with - or -- .";
		$code = 598;
		parent::__construct($message, $code, $previous);
	}
}

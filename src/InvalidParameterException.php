<?php
namespace KentaroA\PHPCommander;

class InvalidParameterException extends \Exception {
	public function __construct(string $message, \Exception $previous=null) {
		$code = 598;
		parent::__construct($message, $code, $previous);
	}
}

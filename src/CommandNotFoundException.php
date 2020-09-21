<?php
namespace KentaroA\PHPCommander;

class CommandNotFoundException extends \Exception {
	public function __construct(string $command_name, \Exception $previous=null) {
		$message = "Command [{$command_name}] not found.";
		$code = 599;
		parent::__construct($message, $code, $previous);
	}
}



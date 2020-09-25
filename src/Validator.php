<?php
namespace KentaroA\PHPCommander;

abstract class Validator {
	private $_error_message;
	final public function __construct(string $error_message) {
		if (trim($error_message) === "") {
			throw new InvalidParameterException("Validator error_message is empty.");
		}
		$this->_error_message = $error_message;
	}

	final public function __invoke($flg, $value): bool {
		if (!$this->validate($flg, $value)) {
			echo $this->_error_message ."\n";
			return false;
		}
		return true;
	}

	abstract public function validate($flg, $value): bool;

}

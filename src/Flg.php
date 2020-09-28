<?php
namespace KentaroA\PHPCommander;

class Flg {
	private $_flg;
	private $_help;
	private $_must;
	private $_validators;

	public function __construct(string $flg, bool $must=false, string $help="", array $validators=[]) {
		if (!preg_match("/^\-{1,2}[^-]+$/", $flg)) {
			throw new InvalidParameterException("Flg [{$flg}] must be started with - or --.");
		}
		foreach ($validators as $v) {
			if (!is_subclass_of($v, 'KentaroA\PHPCommander\Validator')) {
				throw new InvalidParameterException("validator must extends KentaroA\PHPCommander\Validator.");
			}
		}
		$this->_flg = $flg;
		$this->_must = $must;
		$this->_help = $help;
		$this->_validators = $validators;
	}

	public function getFlg() {
		return $this->_flg;
	}

	public function isMust() {
		return $this->_must;
	}

	public function getHelp() {
		return $this->_help;
	}

	public function getValidators() {
		return $this->_validators;
	}
}

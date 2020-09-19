<?php
namespace PHPCommander;

class Flgs {
	private $_flgs;

	public function __construct(array $flgs=[]) {
		foreach ($flgs as $flg=>$help) {
			$this->set($flg, $help);
		}
	}

	public function set(string $flg, string $help): Flgs {
		if (!preg_match("/^\-{1,2}[^-]+$/", $flg)) {
			throw new InvalidFlgException($flg);
		}
		$this->_flgs[$flg] = $help;
		return $this;
	}

	public function getAll(): array {
		return $this->_flgs;
	}

	public function isExist(string $flg): bool {
		return isset($this->_flgs[$flg]);
	}

}

<?php
namespace KentaroA\PHPCommander;

class Flgs {
	private $_flgs=[];

	public function __construct(array $flgs=[]) {
		foreach ($flgs as $flg) {
			$this->set($flg);
		}
	}

	public function set(Flg $flg): Flgs {
		$this->_flgs[$flg->getFlg()] = $flg;
		return $this;
	}

	public function getAll(): array {
		return $this->_flgs;
	}

	public function isExist(string $flg): bool {
		return isset($this->_flgs[$flg]);
	}

}

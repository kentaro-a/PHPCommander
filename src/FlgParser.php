<?php
namespace PHPCommander;

class FlgParser {
	private $_flgs;
	private $_command_name;

	public function __construct(array $argv) {
		$this->_parse($argv);
	}

	private function _parse(array $argv) {
		$this->_command_name = $argv[1] ?? "";
		if (count($argv) > 2) {
			for ($i=2; $i<count($argv); $i++) {
				if (preg_match("/^\-{1,2}[^-]+$/", $argv[$i])) {
					if (isset($argv[$i+1])) {
						if (preg_match("/^\-{1,2}[^-]+$/", $argv[$i+1])) {
							$this->_flgs[$argv[$i]] = "";
							$this->_flgs[$argv[$i+1]] = "";
						} else {
							$this->_flgs[$argv[$i]] = $argv[$i+1];
							$i++;
						}
					} else {
						$this->_flgs[$argv[$i]] = "";
					}
				}
			}
		}
	}

	public function getCommandName(): string {
		return $this->_command_name;
	}

	public function getFlgs(): array {
		return $this->_flgs;
	}


}

<?php
namespace PHPCommander;

class Command {
	private $_command_name;
	private $_procedure;
	private $_flgs;
	private $_description;
	private $_HELP_SEPERATOR = "-----------------------";
	private $_BR = "\n";

	public function __construct(string $command_name, ProcedureInterface $procedure, Flgs $flgs=null, string $description="") {
		$this->_command_name = $command_name;
		$this->_procedure = $procedure;
		$this->_flgs = is_null($flgs) ? new Flgs() : $flgs;
		$this->_description = $description;
	}

	public function getCommandName(): string {
		return $this->_command_name;
	}

	public function getProcedure(): ProcedureInterface {
		return $this->_procedure;
	}

	public function hasFlg(string $flg): bool {
		return $this->_flgs->isExist($flg);
	}

	public function getDescription() {
		return $this->_description;
	}

	public function getHelp(): string {
		$help = [];
		$help[] = $this->_HELP_SEPERATOR;
		$help[] = "Command: " .$this->getCommandName();
		$help[] = $this->getDescription();
		$help[] = $this->_HELP_SEPERATOR;
		$help[] = "Options: ";
		foreach ($this->_flgs->getAll() as $_flg=>$_help) {
			$help[] = "{$_flg}: {$_help}";
		}
		$help[] = $this->_HELP_SEPERATOR;
		$help[] = $this->_BR;
		return implode($this->_BR, $help);
	}

}

<?php
namespace KentaroA\PHPCommander;

class Commander {
	private $_commands = [];
	private $_flg_parser;
	private $_HELP_SEPERATOR = "-----------------------";
	private $_BR = "\n";

	public function __construct(array $argv, array $commands=[]) {
		$this->_flg_parser = new FlgParser($argv);
		foreach ($commands as $command) {
			$this->addCommand($command);
		}
	}

	public function addCommand(Command $command): Commander {
		$this->_commands[$command->getCommandName()] = $command;
		return $this;
	}


	public function getHelp(): string {
		$help = [];
		$help[] = $this->_HELP_SEPERATOR;
		$help[] = "Commands: ";
		foreach ($this->_getCommands() as $_command_name=>$_cmd) {
			$help[] = $_command_name;
		}
		$help[] = $this->_HELP_SEPERATOR;
		$help[] = $this->_BR;
		return implode($this->_BR, $help);
	}


	public function invoke() {
		$command_name = $this->_flg_parser->getCommandName();
		if ($command_name === "") {
			echo $this->getHelp();
			die();
		}

		$cmd = $this->_getCommand($command_name);
		if (is_null($cmd)) {
			throw new CommandNotFoundException($command_name);
		}
		$procedure = $cmd->getProcedure();

		if (count($this->_flg_parser->getFlgs()) === 1 && (isset($this->_flg_parser->getFlgs()["--help"]) || isset($this->_flg_parser->getFlgs()["-h"]))) {
			echo $cmd->getHelp();
			die();
		}
		$options = [];
		foreach ($this->_flg_parser->getFlgs() as $flg=>$v) {
			if ($cmd->hasflg($flg)) {
				$key = preg_replace("/^\-{1,2}/", "", $flg);
				$options[$key] = $v;
			}
		}

		return call_user_func($procedure, $options);
	}

	private function _getCommands(): array {
		return $this->_commands;
	}

	private function _getCommand(string $command_name): ?Command {
		return $this->_commands[$command_name] ?? null;
	}


}



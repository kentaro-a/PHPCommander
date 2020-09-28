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
			echo "Command [$command_name] not found.\nRegistered commands are\n";
			echo $this->getHelp();
			die();
		}
		$procedure = $cmd->getProcedure();

		if (count($this->_flg_parser->getFlgs()) === 1 && (isset($this->_flg_parser->getFlgs()["--help"]) || isset($this->_flg_parser->getFlgs()["-h"]))) {
			echo $cmd->getHelp();
			die();
		}

		$options = [];
		foreach ($cmd->getFlgs()->getAll() as $_flg=>$_f) {
			if (isset($this->_flg_parser->getFlgs()[$_flg])) {
				$vali_errors = 0;
				foreach ($_f->getValidators() as $validator) {
					// validation
					$ok = $validator($_flg, $this->_flg_parser->getFlgs()[$_flg]);
					if (!$ok) {
						$vali_errors++;
					}
				}
				if ($vali_errors > 0) die();

				$key = preg_replace("/^\-{1,2}/", "", $_flg);
				$options[$key] = $this->_flg_parser->getFlgs()[$_flg];

			} else {
				if ($_f->isMust()) {
					echo "Flg {$_flg} is required.";
				}
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



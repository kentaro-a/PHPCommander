<?php
require_once(__DIR__ ."/../vendor/autoload.php");
use KentaroA\PHPCommander\Commander;
use KentaroA\PHPCommander\Command;
use KentaroA\PHPCommander\Flgs;
use KentaroA\PHPCommander\FlgParser;
use KentaroA\PHPCommander\CommandNotFoundException;
use KentaroA\PHPCommander\ProcedureInterface;

class ProcedureVoid implements ProcedureInterface {
	public function __invoke(array $flgs=[]) {
		echo "echo!";
	}
}

class ProcedureReturn implements ProcedureInterface {
	public function __invoke(array $flgs=[]) {
		return $flgs;
	}
}


class CommanderTest extends PHPUnit\Framework\TestCase {

	public function test___construct() {
		$_argv = [
			"scriptname.php",
			"command1",
		];
		$command1 = new Command(
			"command1",
			new ProcedureVoid(),
			new Flgs(),
			"desc",
		);
		$cli = new Commander($_argv, [$command1]);
		$this->assertInstanceOf(Commander::class, $cli);

		$_argv = [
			"scriptname.php",
			"command1",
		];
		$command1 = new Command(
			"command1",
			new ProcedureVoid(),
			new Flgs(),
			"desc",
		);
		$cli = new Commander($_argv);
		$this->assertInstanceOf(Commander::class, $cli);

	}


	public function test_addCommand() {
		$_argv = [
			"scriptname.php",
			"command1",
		];
		$command1 = new Command(
			"command1",
			new ProcedureVoid(),
			new Flgs(),
			"desc",
		);
		$cli = new Commander($_argv, [$command1]);

		$command2 = new Command(
			"command2",
			new ProcedureVoid(),
			new Flgs(),
			"desc2",
		);
		$cli->addCommand($command2);
		$this->assertInstanceOf(Commander::class, $cli);

	}


	public function test_getHelp() {
		$_argv = [
			"scriptname.php",
			"command1",
		];
		$command1 = new Command(
			"command1",
			new ProcedureVoid(),
			new Flgs(),
			"desc",
		);
		$cli = new Commander($_argv, [$command1]);

		$command2 = new Command(
			"command2",
			new ProcedureVoid(),
			new Flgs(),
			"desc2",
		);
		$cli->addCommand($command2);
		$this->assertEquals(preg_match("/command1\ncommand2/", $cli->getHelp()), 1);

	}

	public function test_invoke() {

		$command1 = new Command(
			"command1",
			new ProcedureVoid(),
			new Flgs(),
			"desc",
		);
		$command2 = new Command(
			"command2",
			new ProcedureReturn(),
			new Flgs([
				"-f" => "filename",
			]),
			"desc2",
		);
		$_argv = [
			"scriptname.php",
			"command1",
		];
		$cli = new Commander($_argv, [$command1,$command2]);
		ob_start();
		$cli->invoke();
		$actual = ob_get_clean();
		$this->assertEquals("echo!",$actual);

		$_argv = [
			"scriptname.php",
			"command2",
			"-f",
			"path/to/testfile",
		];
		$cli = new Commander($_argv, [$command1,$command2]);
		$ret = $cli->invoke();
		$this->assertEquals(["f"=>"path/to/testfile"],$ret);
	}

}


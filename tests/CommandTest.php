<?php
require_once(__DIR__ ."/../vendor/autoload.php");
use KentaroA\PHPCommander\Command;
use KentaroA\PHPCommander\Flgs;
use KentaroA\PHPCommander\ProcedureInterface;
use KentaroA\PHPCommander\InvalidParameterException;

class Procedure implements ProcedureInterface {
	public function __invoke(array $flgs=[]) {
		return true;
	}
}


class CommandTest extends PHPUnit\Framework\TestCase {
    public function test___construct_validation1() {
		$this->expectException(InvalidParameterException::class);
		$command1 = new Command(
			"-calc",
			new Procedure(),
			new Flgs([
				"--param1" => "param1",
			]),
			"desc"
		);
	}

	public function test___construct_validation2() {
		$this->expectException(InvalidParameterException::class);
		$command1 = new Command(
			"--calc",
			new Procedure(),
			new Flgs([
				"--param1" => "param1",
			]),
			"desc"
		);
	}

	public function test___construct() {
		$command1 = new Command(
			"calc",
			new Procedure(),
			new Flgs([
				"--param1" => "param1",
			]),
			"desc"
		);
		$this->assertInstanceOf(Command::class, $command1);
	}

	public function test_getCommandName() {
		$command1 = new Command(
			"calc",
			new Procedure(),
			new Flgs([
				"--param1" => "param1",
			]),
			"desc"
		);
		$this->assertEquals($command1->getCommandName(), "calc");
	}


	public function test_getProcedure() {
		$command1 = new Command(
			"calc",
			new Procedure(),
			new Flgs([
				"--param1" => "param1",
			]),
			"desc"
		);
		$this->assertTrue(is_subclass_of($command1->getProcedure(), 'KentaroA\PHPCommander\ProcedureInterface'));
	}

	public function test_hasFlg() {
		$command1 = new Command(
			"calc",
			new Procedure(),
			new Flgs([
				"--param1" => "param1",
			]),
			"desc"
		);
		$this->assertTrue($command1->hasFlg("--param1"));
		$this->assertFalse($command1->hasFlg("param1"));
	}

	public function test_getDescription() {
		$command1 = new Command(
			"calc",
			new Procedure(),
			new Flgs([
				"--param1" => "param1",
			]),
			"desc"
		);
		$this->assertEquals($command1->getDescription(), "desc");
	}

	public function test_getHelp() {
		$command1 = new Command(
			"calc",
			new Procedure(),
			new Flgs([
				"--param1" => "param1",
			]),
			"desc"
		);
		$this->assertNotEmpty($command1->getHelp());
	}


}

<?php
require_once(__DIR__ ."/../vendor/autoload.php");
use KentaroA\PHPCommander\Command;
use KentaroA\PHPCommander\Flgs;
use KentaroA\PHPCommander\Flg;
use KentaroA\PHPCommander\ProcedureInterface;
use KentaroA\PHPCommander\InvalidParameterException;
use KentaroA\PHPCommander\ValidatorNotEmptyString;

class Procedure implements ProcedureInterface {
	public function __invoke(array $flgs=[]) {
		return true;
	}
}


class CommandTest extends PHPUnit\Framework\TestCase {
    public function test___construct_validation1() {
		$this->expectException(InvalidParameterException::class);
		$flg = new Flg("--flg", false, "sample flg[not empty]", [new ValidatorNotEmptyString("Flg --flg doesn't permit blank.")]);
		$command1 = new Command(
			"-calc",
			new Procedure(),
			new Flgs([
				$flg,
			]),
			"desc"
		);
	}

	public function test___construct_validation2() {
		$this->expectException(InvalidParameterException::class);
		$flg = new Flg("--flg", false, "sample flg[not empty]", [new ValidatorNotEmptyString("Flg --flg doesn't permit blank.")]);
		$command1 = new Command(
			"--calc",
			new Procedure(),
			new Flgs([
				$flg,
			]),
			"desc"
		);
	}

	public function test___construct() {
		$flg = new Flg("--flg", false, "sample flg[not empty]", [new ValidatorNotEmptyString("Flg --flg doesn't permit blank.")]);
		$command1 = new Command(
			"calc",
			new Procedure(),
			new Flgs([
				$flg,
			]),
			"desc"
		);
		$this->assertInstanceOf(Command::class, $command1);
	}

	public function test_getCommandName() {
		$flg = new Flg("--flg", false, "sample flg[not empty]", [new ValidatorNotEmptyString("Flg --flg doesn't permit blank.")]);
		$command1 = new Command(
			"calc",
			new Procedure(),
			new Flgs([
				$flg
			]),
			"desc"
		);
		$this->assertEquals($command1->getCommandName(), "calc");
	}


	public function test_getProcedure() {
		$flg = new Flg("--flg", false, "sample flg[not empty]", [new ValidatorNotEmptyString("Flg --flg doesn't permit blank.")]);
		$command1 = new Command(
			"calc",
			new Procedure(),
			new Flgs([
				$flg
			]),
			"desc"
		);
		$this->assertTrue(is_subclass_of($command1->getProcedure(), 'KentaroA\PHPCommander\ProcedureInterface'));
	}

	public function test_hasFlg() {
		$flg = new Flg("--flg", false, "sample flg[not empty]", [new ValidatorNotEmptyString("Flg --flg doesn't permit blank.")]);
		$command1 = new Command(
			"calc",
			new Procedure(),
			new Flgs([
				$flg
			]),
			"desc"
		);
		$this->assertTrue($command1->hasFlg("--flg"));
		$this->assertFalse($command1->hasFlg("flg"));
	}

	public function test_getDescription() {
		$flg = new Flg("--flg", false, "sample flg[not empty]", [new ValidatorNotEmptyString("Flg --flg doesn't permit blank.")]);
		$command1 = new Command(
			"calc",
			new Procedure(),
			new Flgs([
				$flg
			]),
			"desc"
		);
		$this->assertEquals($command1->getDescription(), "desc");
	}

	public function test_getHelp() {
		$flg = new Flg("--flg", false, "sample flg[not empty]", [new ValidatorNotEmptyString("Flg --flg doesn't permit blank.")]);
		$command1 = new Command(
			"calc",
			new Procedure(),
			new Flgs([
				$flg
			]),
			"desc"
		);
		$this->assertNotEmpty($command1->getHelp());
	}


}

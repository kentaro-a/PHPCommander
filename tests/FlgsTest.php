<?php
require_once(__DIR__ ."/../vendor/autoload.php");
use KentaroA\PHPCommander\Flgs;
use KentaroA\PHPCommander\Flg;
use KentaroA\PHPCommander\InvalidParameterException;
use KentaroA\PHPCommander\ValidatorNotEmptyString;

class FlgsTest extends PHPUnit\Framework\TestCase {

	public function test___construct_validation() {
		$this->expectException(InvalidParameterException::class);
		$flg = new Flg("flg", true, "sample flg", [new ValidatorNotEmptyString("Flg --flg doesn't permit blank.")]);
		$flgs = new Flgs($params);
	}

	public function test___construct() {

		$flg1 = new Flg("-flg1", true, "sample flg", [new ValidatorNotEmptyString("Flg --flg doesn't permit blank.")]);
		$flg2 = new Flg("--flg2", true, "sample flg", [new ValidatorNotEmptyString("Flg --flg doesn't permit blank.")]);
		$flgs = new Flgs([$flg1,$flg2]);
		$this->assertInstanceOf(Flgs::class, $flgs);

		$flgs2 = new Flgs();
		$this->assertInstanceOf(Flgs::class, $flgs2);

	}


	public function test_set() {
		$flgs = new Flgs();
		$flg1 = new Flg("-flg1", true, "sample flg", [new ValidatorNotEmptyString("Flg --flg doesn't permit blank.")]);
		$flg2 = new Flg("--flg2", true, "sample flg", [new ValidatorNotEmptyString("Flg --flg doesn't permit blank.")]);
		$flgs->set($flg1);
		$flgs->set($flg2);
		$this->assertInstanceOf(Flgs::class, $flgs);
	}

	public function test_getAll() {
		$flg1 = new Flg("--flg1", true, "sample flg", [new ValidatorNotEmptyString("Flg --flg doesn't permit blank.")]);
		$flg2 = new Flg("--flg2", true, "sample flg", [new ValidatorNotEmptyString("Flg --flg doesn't permit blank.")]);
		$flgs = new Flgs([$flg1]);
		$flgs->set($flg2);
		$this->assertEquals($flgs->getAll(), ["--flg1"=>$flg1,"--flg2"=>$flg2]);
	}

	public function test_isExist() {
		$flgs = new Flgs([new Flg("--flg1", true, "sample flg", [new ValidatorNotEmptyString("Flg --flg doesn't permit blank.")])]);
		$flg2 = new Flg("--flg2", true, "sample flg", [new ValidatorNotEmptyString("Flg --flg doesn't permit blank.")]);
		$flgs->set($flg2);
		$this->assertEquals($flgs->isExist("--flg1"), true);
		$this->assertEquals($flgs->isExist("--flg2"), true);
		$this->assertEquals($flgs->isExist("--flg3"), false);
	}
}


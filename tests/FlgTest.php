<?php
require_once(__DIR__ ."/../vendor/autoload.php");
use KentaroA\PHPCommander\InvalidParameterException;
use KentaroA\PHPCommander\Flg;
use KentaroA\PHPCommander\Flgs;
use KentaroA\PHPCommander\ValidatorNotEmptyString;

class FlgTest extends PHPUnit\Framework\TestCase {

	public function test___construct_validation() {
		$this->expectException(InvalidParameterException::class);
		$flg = new Flg("flg1");
	}

	public function test___construct_validation2() {
		$this->expectException(InvalidParameterException::class);
		$flg = new Flg("flg1", true, "", ["string"]);
	}

	public function test___construct() {
		$flg1 = new Flg("-flg1");
		$flg2 = new Flg("--flg2", true, "sample flg2[must]");
		$flg3 = new Flg("--flg2", false, "sample flg3[not empty]", [new ValidatorNotEmptyString("Flg --flg3 doesn't permit blank.")]);
		$flgs = new Flgs([$flg1, $flg2, $flg3]);

		$this->assertInstanceOf(Flgs::class, $flgs);
	}

	public function test_getFlg() {
		$flg = new Flg("-flg");
		$this->assertEquals($flg->getFlg(), "-flg");
	}

	public function test_isMust() {
		$flg = new Flg("-flg", true);
		$this->assertEquals($flg->isMust(), true);
		$flg2 = new Flg("-flg", false);
		$this->assertEquals($flg2->isMust(), false);
	}

	public function test_getHelp() {
		$flg = new Flg("-flg", true, "help");
		$this->assertEquals($flg->getHelp(), "help");
	}

	public function test_getValidators() {
		$flg = new Flg("--flg", true, "sample flg", [new ValidatorNotEmptyString("Flg --flg doesn't permit blank.")]);
		$this->assertIsArray($flg->getValidators());
	}
}


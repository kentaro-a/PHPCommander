<?php
require_once(__DIR__ ."/../vendor/autoload.php");
use KentaroA\PHPCommander\InvalidParameterException;
use KentaroA\PHPCommander\Flg;
use KentaroA\PHPCommander\Flgs;
use KentaroA\PHPCommander\ValidatorNotEmptyString;

class ValidatorTest extends PHPUnit\Framework\TestCase {

	public function test___construct_validation() {
		$this->expectException(InvalidParameterException::class);
		$v = new ValidatorNotEmptyString("");
	}

	public function test___construct() {
		$v = new ValidatorNotEmptyString("message");
		$this->assertTrue(is_subclass_of($v, 'KentaroA\PHPCommander\Validator'));
	}

	public function test___invoke() {
		$v = new ValidatorNotEmptyString("message");
		$r = $v("f","");
		$this->assertEquals(false, $r);
		$r = $v("f","  ");
		$this->assertEquals(false, $r);
		$r = $v("f","a");
		$this->assertEquals(true, $r);
	}

}

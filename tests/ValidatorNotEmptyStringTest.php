<?php
require_once(__DIR__ ."/../vendor/autoload.php");
use KentaroA\PHPCommander\InvalidParameterException;
use KentaroA\PHPCommander\Flg;
use KentaroA\PHPCommander\Flgs;
use KentaroA\PHPCommander\ValidatorNotEmptyString;

class ValidatorNotEmptyStringTest extends PHPUnit\Framework\TestCase {

	public function test___construct_validation() {
		$this->expectException(InvalidParameterException::class);
		$v = new ValidatorNotEmptyString("");
	}

	public function test___construct() {
		$v = new ValidatorNotEmptyString("message");
		$this->assertInstanceOf(ValidatorNotEmptyString::class, $v);
	}

}

<?php
require_once(__DIR__ ."/../vendor/autoload.php");
use KentaroA\PHPCommander\Flgs;
use KentaroA\PHPCommander\InvalidParameterException;

class FlgsTest extends PHPUnit\Framework\TestCase {

	public function test___construct_validation() {
		$this->expectException(InvalidParameterException::class);
		$params = [
			"flg1" => "val1",
		];
		$flgs = new Flgs($params);
	}

	public function test___construct() {
		$params = [
			"-flg1" => "val1",
			"--flg2" => "val2",
		];
		$flgs = new Flgs($params);
		$this->assertInstanceOf(Flgs::class, $flgs);

		$flgs2 = new Flgs();
		$this->assertInstanceOf(Flgs::class, $flgs2);

	}

	public function test_set_varidation() {
		$this->expectException(InvalidParameterException::class);
		$flgs = new Flgs();
		$flgs->set("f", "val1");
	}

	public function test_set() {
		$flgs = new Flgs();
		$flgs->set("-f", "val1");
		$flgs->set("--flg2", "val2");
		$this->assertInstanceOf(Flgs::class, $flgs);
	}

	public function test_getAll() {
		$flgs = new Flgs(["--flg1"=>"val1"]);
		$flgs->set("--flg2", "val2");
		$this->assertEquals($flgs->getAll(), ["--flg1"=>"val1","--flg2"=>"val2"]);
	}

	public function test_isExist() {
		$flgs = new Flgs(["--flg1"=>"val1"]);
		$flgs->set("--flg2", "val2");
		$this->assertEquals($flgs->isExist("--flg1"), true);
		$this->assertEquals($flgs->isExist("--flg2"), true);
		$this->assertEquals($flgs->isExist("--flg3"), false);
	}
}


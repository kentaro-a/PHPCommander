<?php
require_once(__DIR__ ."/../vendor/autoload.php");
use KentaroA\PHPCommander\FlgParser;

class FlgParserTest extends PHPUnit\Framework\TestCase {


	public function test___construct() {
		$_argv = [
			"scriptname.php",
		];
		$parser = new FlgParser($_argv);
		$this->assertInstanceOf(FlgParser::class, $parser);
	}

	public function test_getCommandName() {
		$_argv = [
			"scriptname.php",
			"cmdname",
		];
		$parser = new FlgParser($_argv);
		$this->assertEquals($parser->getCommandName(), "cmdname");

		$_argv = [
			"scriptname.php",
		];
		$parser = new FlgParser($_argv);
		$this->assertEquals($parser->getCommandName(), "");
	}

	public function test_getFlgs() {
		$_argv = [
			"scriptname.php",
			"cmdname",
			"-f",
			"filename",
			"--directory",
			"dirname",
			"-r",
			"-a"
		];
		$parser = new FlgParser($_argv);
		$flgs = $parser->getFlgs();
		$this->assertIsArray($flgs);
		$this->assertEquals($parser->getCommandName(), "cmdname");
		$this->assertEquals($flgs["-f"], "filename");
		$this->assertEquals($flgs["--directory"], "dirname");
		$this->assertEquals($flgs["-r"], "");
		$this->assertEquals($flgs["-a"], "");
		$this->assertNull($flgs["-b"]);

		$_argv = [
			"scriptname.php",
			"cmdname",
		];
		$parser = new FlgParser($_argv);
		$this->assertCount(0, $parser->getFlgs());

	}

}


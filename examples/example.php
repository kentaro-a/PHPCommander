<?php
/*
 * $ php example.php hello --param "hello world"
 * $ php example.php get_license
 */

require_once(__DIR__ ."/../vendor/autoload.php");
use KentaroA\PHPCommander\Commander;
use KentaroA\PHPCommander\Command;
use KentaroA\PHPCommander\Flgs;
use KentaroA\PHPCommander\FlgParser;
use KentaroA\PHPCommander\CommandNotFoundException;
use KentaroA\PHPCommander\ProcedureInterface;

class EchoProcedure implements ProcedureInterface {
	public function __invoke(array $flgs=[]) {
		echo $flgs["param"] ."\n";
	}
}

class GetLicenseProcedure implements ProcedureInterface {
	public function __invoke(array $flgs=[]) {
		return file_get_contents(__DIR__ ."/../LICENSE");
	}
}

$commands = [];
$command_echo = new Command(
	"echo",
	new EchoProcedure(),
	new Flgs([
		"--param" => "sample parameter",
	]),
	"Simple echo parameter",
);
$commands[] = $command_hello;

$command_get_license = new Command(
	"get_license",
	new GetLicenseProcedure(),
	new Flgs(),
	"Get license text",
);
$commands[] = $command_get_license;

$cli = new Commander($argv, $commands);
$ret = $cli->invoke();
if ($ret) {
	echo $ret;
}


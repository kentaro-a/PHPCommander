<?php
/*
 * $ php example.php echo --param "hello world"
 * $ php example.php get_license
 */

require_once(__DIR__ ."/../vendor/autoload.php");
use KentaroA\PHPCommander\Commander;
use KentaroA\PHPCommander\Command;
use KentaroA\PHPCommander\Flgs;
use KentaroA\PHPCommander\FlgParser;
use KentaroA\PHPCommander\ProcedureInterface;
use KentaroA\PHPCommander\InvalidParameterException;
use KentaroA\PHPCommander\Validator;
use KentaroA\PHPCommander\ValidatorNotEmptyString;
use KentaroA\PHPCommander\Flg;

class EchoProcedure implements ProcedureInterface {
	public function __invoke(array $flgs=[]) {
		echo $flgs["param"] .($flgs["dt"] ?? "") ."\n";
	}
}

class GetLicenseProcedure implements ProcedureInterface {
	public function __invoke(array $flgs=[]) {
		echo file_get_contents(__DIR__ ."/../LICENSE");
		echo "\n";
	}
}

class ValidatorDatetimeFormat extends Validator {
	public function validate($flg, $value): bool {
		if (preg_match("/^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$/", $value)) {
			return true;
		} else {
			return false;
		}
	}

}

try {
	$validators = [
		new ValidatorNotEmptyString("Flg --param doesn't permit blank."),
	];
	$flg1 = new Flg("--param", true, "my parameter", [new ValidatorNotEmptyString("Flg --param doesn't permit blank.")]);
	$flg2 = new Flg("--dt", false, "my dt", [new ValidatorDatetimeFormat("Flg --dt must be yyyy-mm-dd.")]);

	$commands = [];
	$command_echo = new Command(
		"echo",
		new EchoProcedure(),
		new Flgs([$flg1, $flg2]),
		"Simple echo parameter",
	);
	$commands[] = $command_echo;

	$command_get_license = new Command(
		"get_license",
		new GetLicenseProcedure(),
		new Flgs(),
		"Get license text",
	);
	$commands[] = $command_get_license;

	$cli = new Commander($argv, $commands);
	$ret = $cli->invoke();

} catch (InvalidParameterException $e) {
	var_dump($e);
} catch (Exception $e) {
	var_dump($e);
}


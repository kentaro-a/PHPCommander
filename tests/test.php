<?php
require __DIR__ ."/../vendor/autoload.php";
use PHPCommander\Commander;
use PHPCommander\Command;
use PHPCommander\ProcedureInterface;
use PHPCommander\Flgs;
use PHPCommander\CommandNotFoundException;
use PHPCommander\InvalidFlgException;

class MyProcedure implements ProcedureInterface {
	public function __invoke(array $flgs=[]) {
		var_dump($flgs);
	}
}


try {
	$command1 = new Command(
		"exec",
		new MyProcedure(),
		new Flgs([
			"--dt" => "target date (datetime)",
		]),
		"Execute dailybatch\nrequires; --dt",
	);
	$command2 = new Command(
		"exec2",
		new MyProcedure(),
		new Flgs([
			"--dtaaaa" => "target date (datetime)",
		])
	);

	$cli = new Commander($argv, [$command1]);
	$cli->addCommand($command2);
	$cli->invoke();

} catch (InvalidFlgException $e) {
	echo "InvalidFlgException\n";
	echo $e->getMessage()."\n";

} catch (CommandNotFoundException $e) {
	echo "CommandNotFoundException\n";
	echo $e->getMessage()."\n";

} catch (\Exception $e) {
	echo "Exception\n";
	echo $e->getMessage()."\n";
}


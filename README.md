# PHPCommander
Easy to handle flags and options which passed through by $argv.
Flags and options have to be start with "-" or "--".

You can add procedure which implements ProcedureInterface into command.

```
// Make command which can handles options like [php xxx.php echo --param !sample!!"]
$command_echo = new Command(
	"echo",
	new EchoProcedure(),
	new Flgs([
		"--param" => "sample parameter",
	]),
	"Simple echo parameter",
);
// you can add other command by pushing into $commands or using add method like $cli->addCommand($command).
$commands[] = $command_hello;

// Make instance.
$cli = new Commander($argv, $commands);
// Invoke procedure related on command name passed by $argv
$ret = $cli->invoke();
```

# Detail
See [examples](https://github.com/kentaro-a/PHPCommander/tree/master/examples).

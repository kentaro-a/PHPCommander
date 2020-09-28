# PHPCommander
Easy to handle flags and options which passed through by $argv.
Flags and options have to be start with "-" or "--".
If you've already have any classes and you'd like to make something like CLI batches with it, PHPCommander makes it easy.

# Requirements
- php >= 7.1

# Install
```
$ composer require kentaro-a/phpcommander
```

# How To Use
### You can make Procedure which implements [ProcedureInterface](https://github.com/kentaro-a/PHPCommander/blob/master/src/ProcedureInterface.php).

```
class EchoProcedure implements ProcedureInterface {
	public function __invoke(array $flgs=[]) {
		// Whatever you want.
		echo $flgs["param"] ."\n";
	}
}
```

### Make Flags for command
Use Flg(string $flg, bool $must=false, string $help="", array $validators=[]) to make Flag.
you can make custom validator class like preset validator ValidatorNotEmptyString.

| param | desc |
----|---- 
| $flg | require, this must start with - or -- |
| $must | optional default=false, if true check for being passed flg in cli args. |
| $help | optional default="", help text to be shown. |
| $validators | optional default=[], an array of sub classes of Validator to validate flg. |

```
$flg1 = new Flg("--param", true, "my parameter", [new ValidatorNotEmptyString("Flg --param doesn't permit blank.")]);
```


After making Procedure you can set it into Command and make Commander which contains Command[s].
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
$commands[] = $command_echo;

// Make instance.
$cli = new Commander($argv, $commands);
```

Commander::invoke obtains command name and options from $argv then invokes relevant Procedure::__invoke().
```
// Invoke procedure related on command name passed by $argv
$ret = $cli->invoke();
```

# Detail
See [examples](https://github.com/kentaro-a/PHPCommander/tree/master/examples).

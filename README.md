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

### Make Flags for command
Use new Flg(string $flg, bool $must=false, string $help="", array $validators=[]) to make Flag.
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

### You can make Procedure which implements [ProcedureInterface](https://github.com/kentaro-a/PHPCommander/blob/master/src/ProcedureInterface.php).

```
class EchoProcedure implements ProcedureInterface {
	public function __invoke(array $flgs=[]) {
		// Whatever you want.
		echo $flgs["param"] ."\n";
	}
}
```

### Make Command
After making Procedure you can set it into Command.
Using new Command(string $command_name, ProcedureInterface $procedure, Flgs $flgs=null, string $description="").

| param | desc |
----|---- 
| $command_name | require, this must not start with - or -- |
| $procedure | require, procedure to be called when command passed. |
| $flgs | optional default=null, Flgs class contains an array of Flg classes. |
| $description | optional default="", description text to be shown in help. |

```
$command_echo = new Command(
	"echo",
	new EchoProcedure(),
	new Flgs([$flg1]),
	"Simple echo parameter",
);
```

### Add Commands into Commander and invoke registered command.

Commander::invoke obtains command name and options from $argv then invokes relevant Procedure::__invoke().
```
// Make instance.
$cli = new Commander($argv, [$command_echo]);

// you can also add other command by pushing into $commands or using add method like $cli->addCommand($command).

// Invoke procedure related on command name passed by $argv
$ret = $cli->invoke();
```


# Show help.
You can show registered command list without any parameters.
```
$ php batch.php
```

You can also pass the reserved flg after command_name like -h or --help to show help.
```
$ php batch.php echo -h(--help)
```

# Detail
See [examples](https://github.com/kentaro-a/PHPCommander/tree/master/examples).

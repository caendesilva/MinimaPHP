# MinimaPHP

Minimal PHP micro-framework for creating general purpose command-line scripts

## Installation

Copy the `minima.php` file to your project, include it from your main script. You're done.

## Usage

Write your logic in a closure through the `Command::main()` method or the `main()` function. You will then be able to access all the helpers through the `$this` variable.

```php
<?php

require_once 'minima.php';

Command::main(function (): void {
    $this->info('Welcome to MinimaPHP!');
});
```

### Exit codes

If your closure function returns an exit code, the `main` method/function will return that as well. You can then use this to set the exit code for your script:

```php
exit(Command::main(function (): int {
    return 1;
}));
```

## Interacting with I/O

Minima is designed to abstract away the lower level I/O calls, and using these helpers is what makes the framework helpful, compared to having to deal with these yourself.


### Output helpers

#### Simple output

```php
$this->write('This is written "inline" to the output');
$this->line('This writes the string to the output, then adds a newline.');
```

#### Coloured output

These helpers will write a line using predefined colours.

```php
$this->info('info');
$this->warning('warning');
$this->error('error');
```

#### Fluent coloured output

You can also use Symfony-XML-style colours when using the formatted helper:

```php
$this->formatted('<info>Welcome to MinimaPHP!</info> <comment>Star us on GitHub?</comment>');
```

##### The following colours are supported:

- `<info>`
- `<warning>`
- `<error>`
- `<comment>`
- `<reset>`

You can also use `</>` to close any tag.

#### Predefined ANSI colour constants

You can fluently access ANSI colour codes using the bundled ANSI interface:

```php
interface ANSI {
    const BLACK   = "\033[30m";
    const RED     = "\033[31m";
    const GREEN   = "\033[32m";
    const YELLOW  = "\033[33m";
    const BLUE    = "\033[34m";
    const MAGENTA = "\033[35m";
    const CYAN    = "\033[36m";
    const WHITE   = "\033[37m";
    const GRAY    = "\033[90m";
    const RESET   = "\033[0m";
}

$this->line(ANSI::GREEN . $message . ANSI::RESET);
```

### Input helpers

#### Asking for input

Use the `ask` helper to write the prompt to the console, and return the collected input.

```php
$this->line('Hello ' . $this->ask('Name'));
```

### Arguments & Options

Minima also makes it easy to access arguments and options passed to the command.

#### Using options

Options are defined as any argument starting with `-` or `--` like any of the following:

```bash
php my-script.php -v --help --foo=bar
```

These types of arguments are generally optional, hence the name, and when not supplied with any extra data like the `foo=bar` example, are usually used as boolean flags.

#### Using arguments

Arguments are generally required, and can either be positional, or keyed.

```bash
php my-script.php example bar=baz
```

If your argument contains spaces, you must quote them, otherwise the parser considers them to be separate arguments.

### Accessing the options and arguments

#### Array access

Options can be accessed using the `options` array, and arguments using the `arguments` array. You can also access them through the `options()` and `arguments()` methods.

```php
Command::main(function () {
    $this->info('Here is the data you passed to the command:');
    $this->line('Options: ' . implode(', ', $this->options));
    $this->line('Arguments: ' . implode(', ', $this->arguments));
});
```

Options will be returned as a list like this, where the option name is used as the array key, with the value as the value. If your option is a boolean flag, the value will be set to `true`.

```php
// --help -v --foo=bar
['help' => true, 'v' => true, 'foo' => 'bar']
```

Likewise, arguments accessed through the method are also in an associative array, but here, if the argument has no assigned value (using the equals sign), it's array key will be set to it's position in the array. If the argument is associative, the array key will be the left-hand part of the argument. In both cases, the value will be the argument value.


```php
// example foo=bar baz
[0 => 'example', 'foo' => 'bar', 2 => 'baz']
```

#### State helpers

Use `hasArgument` and `hasOption` to determine if the argument or option was passed to the command.

```php
$this->hasArgument('foo'): bool;
$this->hasOption('foo'): bool;
```

#### Getters

You can use the `getArgument` and `getOption` helpers to get a value from the passed input.

```php
$this->getArgument('foo'): ?mixed);
$this->getOption('foo'): ?mixed);
```

You can also specify a default value by setting the second parameter:

```php
$this->line('Your name is ' . $this->getArgument('name', 'Guest'));
```

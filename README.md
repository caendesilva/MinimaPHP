# MinimaPHP

<a href="https://github.com/caendesilva/MinimaPHP/blob/main/LICENSE.md"><img src="https://img.shields.io/github/license/caendesilva/MinimaPHP" alt="License MIT" style="display: inline; margin: 0 2px;"></a>
<a href="https://github.com/caendesilva/MinimaPHP/actions/workflows/run-unit-tests.yml"><img src="https://github.com/caendesilva/MinimaPHP/actions/workflows/run-unit-tests.yml/badge.svg" alt="Unit Tests" style="display: inline; margin: 0 2px;"></a>
<a href="https://github.com/caendesilva/MinimaPHP/blob/main/tests/coverage.json"><img src="https://img.shields.io/endpoint?url=https://raw.githubusercontent.com/caendesilva/MinimaPHP/main/tests/coverage.json" alt="Test Coverage" style="display: inline; margin: 0 2px;"></a>

## About

MinimaPHP is a PHP console micro-framework for quickly creating fast general purpose command-line scripts, usually to automate boring tasks, using the PHP tools you're already familiar with. Minima provides easy helpers to interact with the CLI I/O, making it a breeze to build powerful and dynamic scripts.

```php
<?php

require_once 'minima.php';

Command::main(function () {
    $this->info('Welcome to MinimaPHP!');
});
```

### Benefits

The main benefit of using MinimaPHP is that it has **zero dependencies**. You thus don't need to bother with Composer or autoloading. Just include the single compact `minima.php` file, and you're ready to go. That's right, you don't even need a Phar, because Minima is tiny (< 10Kb).

### The Philosophy

Since Minima is designed for scripting, the philosophy is that your Minima projects don't need to be pretty, they just need to do the thing you want them to do. If all you're doing is [formatting some files](https://github.com/caendesilva/MinimaPHP/blob/main/build/FileFormatter.php), or [compiling a file to a standalone executable](https://github.com/caendesilva/MinimaPHP/blob/main/build/build-bin.php), who cares if the code looks ugly, as long as it works! Just bodge something together, then call it a day.


## Installation

Copy the `minima.php` file to your project, include it from your main script. You're done.

### Global installer (Linux/Unix/macOS)

If you want, you can install the global `Minima` binary. It's a script written in MinimaPHP, and allows you to quickly scaffold new projects.

```bash
curl https://raw.githubusercontent.com/caendesilva/MinimaPHP/main/bin/minima -o minima
chmod +x minima
mv minima /usr/local/bin/minima
```

You can then call the command from anywhere, like this:

```bash
minima new my-project
```

## Usage

Write your logic in a closure through the `Command::main()` method or the `main()` function. You will then be able to access all the helpers through the `$this` variable.

```php
<?php

require_once 'minima.php';

Command::main(function (): void {
    $this->info('Welcome to MinimaPHP!');
});
```

If you prefer functional code, we've got it covered. Here's a simple one-line procedural script to get the current time:
```php
exit(main(fn () => $this->info('The time is: ' . date('c'))));
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

You can also specify a default value by setting the second parameter of the `ask` helper.

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

## Included code APIs

To make your life easier, Minima comes with a few code APIs you can use to write scripts faster than ever!

### Task Function

The `task` function creates a self-contained task that does something and reports the execution time.
The benefit of using a task like this is that if you set the environment variable SKIP_TASKS to true, the command will bypass all tasks. This is useful for skipping long-running tasks when testing your script during coding.

#### Function Parameters
This function takes two parameters:

- `$name` (string) - A string that represents the name of the task.
- `$task` (callable) - A callable function that represents the task to be executed.

#### Example

```php
Command::main(function () {
    task('Example Task', function () {
        $this->line('Hello world!');
    });
});
```

This will print the following: (any output will be buffered and printed indented when the command is done)

```
Running task Example Task... Done! (took 0.01ms)
  Hello world!
```

#### Skipping tasks

The tasks are made useful by being skippable. You can either do this by setting the environment variable before defining the task:

```php
putenv('SKIP_TASKS=true');
```

You can also pass `--skip-tasks` to the called command to automatically set the environment variable.

```bash
php my-script --skip-tasks
```


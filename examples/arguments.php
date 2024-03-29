<?php

require_once 'minima.php';

Command::main(function () {
    $this->info('Here is the data you passed to the command:');
    $this->line('Options: '.implode_array($this->options()));
    $this->line('Arguments: '.implode_array($this->arguments()));

    $this->formatted('<comment>Argument/option access:</>');
    $this->line('Has argument foo? '.print_bool($this->hasArgument('foo')));
    $this->line('Has option foo? '.print_bool($this->hasOption('foo')));
    $this->line('Get argument foo: '.$this->getArgument('foo', 'null'));
    $this->line('Get option foo: '.$this->getOption('foo', 'null'));
});

// For example: `php examples/arguments.php example --help -v --foo=bar bar=baz`
// Will return:
//   Here is the data you passed to the command:
//   Options: --help, -v, --foo=bar
//   Arguments: example, bar=baz

function implode_array(array $array): string
{
    $merged = [];
    foreach ($array as $key => $value) {
        if (is_bool($value)) {
            $value = print_bool($value);
        } elseif (is_string($value)) {
            $value = "'$value'";
        }
        if (is_string($key)) {
            $key = "'$key'";
        }
        $merged[] = "[$key => $value]";
    }

    return implode(', ', $merged);
}

function print_bool(bool $bool): string {
    return $bool ? 'true' : 'false';
}

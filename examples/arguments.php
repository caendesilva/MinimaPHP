<?php

require_once 'minima.php';

Command::main(function () {
    $this->info('Here is the data you passed to the command:');
    $this->line('Options: ' . implode(', ', $this->options));
    $this->line('Arguments: ' . implode(', ', $this->arguments));

    $this->formatted('<comment>Formatted versions:</>');
    $this->line('Options: ' . implode_array($this->options()));
    $this->line('Arguments: ' . implode_array($this->arguments()));
});

// For example: `php examples/arguments.php example --help -v --foo=bar bar=baz`
// Will return:
//   Here is the data you passed to the command:
//   Options: --help, -v, --foo=bar
//   Arguments: example, bar=baz

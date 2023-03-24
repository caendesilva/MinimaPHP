<?php

require_once 'minima.php';

Command::main(function () {
    $this->info('Here is the data you passed to the command:');
    $this->line('Options:' . implode(', ', $this->options));
    $this->line('Arguments:' . implode(', ', $this->Arguments));
});

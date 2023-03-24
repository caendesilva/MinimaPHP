<?php

require_once 'minima.php';

$exitCode = Command::main(function (): void {
    $this->formatted('<info>Welcome to MinimaPHP!</info> <comment>You are running version '.Minima::VERSION.'.</comment>');
});

exit($exitCode);

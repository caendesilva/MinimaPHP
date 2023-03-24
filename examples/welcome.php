<?php

require_once 'minima.php';

$exitCode = Command::main(function () {
    $this->formatted('<info>Welcome to MinimaPHP!</info> <comment>You are running version '.Minima::VERSION.'.</comment>');
});

exit($exitCode);

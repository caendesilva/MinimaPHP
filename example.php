<?php

require_once 'src/minima.php';

$exitCode = Command::main(function () {
	$this->line('Welcome to MinimaPHP! You are running version '.Minima::VERSION.'.');
});

exit($exitCode);

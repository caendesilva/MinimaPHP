<?php

require_once __DIR__ . '/../src/minima.php';

$exitCode = Command::main(function () {
	$this->formatted('<info>Running unit tests!</info>');
});

exit($exitCode);

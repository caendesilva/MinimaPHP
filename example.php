<?php

require_once 'src/minima.php';

$exitCode = Command::main(function () {
	$this->line('Hello World!');
});

exit($exitCode);

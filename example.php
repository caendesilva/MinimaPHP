<?php

require_once 'src/minima.php';

$exitCode = Command::main(function () {
	$this->console->line('Hello World!');
});

exit($exitCode);

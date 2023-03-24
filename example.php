<?php

require_once 'src/minima.php';

$exitCode = Command::main(function (Command $command) {
	Console::line('Hello World!');
});

exit($exitCode);

<?php

require_once __DIR__ . '/../src/minima.php';

$exitCodes = [
	Command::main(function () {
		$this->formatted('<info>Running unit tests!</info>');
	})
];

exit(max($exitCodes));

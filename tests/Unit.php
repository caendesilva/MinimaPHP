<?php

require_once __DIR__ . '/../src/minima.php';

use Command as Test;

$exitCodes = [
	Command::main(function () {
		$this->formatted('<info>Running unit tests!</info>');
	})
];

exit(max($exitCodes));

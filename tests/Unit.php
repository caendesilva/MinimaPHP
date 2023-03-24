<?php

require_once __DIR__ . '/../src/minima.php';

use Command as Test;

$exitCodes = [
	Command::main(function () {
		$this->formatted('<info>Running unit tests!</info>');
	}),

	Test::main(function () {
		$this->info('Testing: WritesToConsole');

		$this->line('---------');
		$this->write('write');
		$this->line('line');
		$this->info('info');
		$this->warning('warning');
		$this->error('error');
		$this->formatted('formatted');
		$this->line('---------');
	}),
];

exit(max($exitCodes));

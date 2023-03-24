<?php

require_once __DIR__ . '/../src/minima.php';

use Command as Test;

$exitCodes = [
	Command::main(function () {
		$this->formatted('<info>Running unit tests!</info>');
	}),

	Test::main(function () {
		$this->info('Testing: ANSI Interface');

		assert(ANSI::BLACK === "\033[30m");
		assert(ANSI::RED === "\033[31m");
		assert(ANSI::GREEN === "\033[32m");
		assert(ANSI::YELLOW === "\033[33m");
		assert(ANSI::BLUE === "\033[34m");
		assert(ANSI::MAGENTA === "\033[35m");
		assert(ANSI::CYAN === "\033[36m");
		assert(ANSI::WHITE === "\033[37m");
		assert(ANSI::GRAY === "\033[90m");
		assert(ANSI::RESET === "\033[0m");
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

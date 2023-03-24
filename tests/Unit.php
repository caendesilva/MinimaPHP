<?php

require_once __DIR__ . '/../src/minima.php';

use Command as Test;

$exitCodes = [
    Command::main(function () {
        $this->formatted('<info>Running unit tests!</info>');
    }),

    Test::main(function () {
        $this->info('Testing: ANSI Interface');

        echo (assert(ANSI::BLACK === "\033[30m") ? 'Assertion passed' : 'Assertion failed') . PHP_EOL;
        echo (assert(ANSI::RED === "\033[31m") ? 'Assertion passed' : 'Assertion failed') . PHP_EOL;
        echo (assert(ANSI::GREEN === "\033[32m") ? 'Assertion passed' : 'Assertion failed') . PHP_EOL;
        echo (assert(ANSI::YELLOW === "\033[33m") ? 'Assertion passed' : 'Assertion failed') . PHP_EOL;
        echo (assert(ANSI::BLUE === "\033[34m") ? 'Assertion passed' : 'Assertion failed') . PHP_EOL;
        echo (assert(ANSI::MAGENTA === "\033[35m") ? 'Assertion passed' : 'Assertion failed') . PHP_EOL;
        echo (assert(ANSI::CYAN === "\033[36m") ? 'Assertion passed' : 'Assertion failed') . PHP_EOL;
        echo (assert(ANSI::WHITE === "\033[37m") ? 'Assertion passed' : 'Assertion failed') . PHP_EOL;
        echo (assert(ANSI::GRAY === "\033[90m") ? 'Assertion passed' : 'Assertion failed') . PHP_EOL;
        echo (assert(ANSI::RESET === "\033[0m") ? 'Assertion passed' : 'Assertion failed') . PHP_EOL;
    }),

    Test::main(function () {
        $this->info('Testing: XML_ANSI Interface');

        echo (assert(XML_ANSI::INFO === ANSI::GREEN) ? 'Assertion passed' : 'Assertion failed') . PHP_EOL;
        echo (assert(XML_ANSI::WARNING === ANSI::YELLOW) ? 'Assertion passed' : 'Assertion failed') . PHP_EOL;
        echo (assert(XML_ANSI::ERROR === ANSI::RED) ? 'Assertion passed' : 'Assertion failed') . PHP_EOL;
        echo (assert(XML_ANSI::COMMENT === ANSI::GRAY) ? 'Assertion passed' : 'Assertion failed') . PHP_EOL;
        echo (assert(XML_ANSI::RESET === ANSI::RESET) ? 'Assertion passed' : 'Assertion failed') . PHP_EOL;
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

<?php

require_once __DIR__ . '/../minima.php';
require_once __DIR__ . '/PicoUnit.php';

use PicoUnit as TestCase;

TestCase::$startMessage = "%sRunning unit tests\n";

TestCase::boot(__FILE__);

Command::main(function () {
    $this->formatted("\n<warning>Testing: ANSI Interface</warning>");

    test(ANSI::BLACK === "\033[30m");
    test(ANSI::RED === "\033[31m");
    test(ANSI::GREEN === "\033[32m");
    test(ANSI::YELLOW === "\033[33m");
    test(ANSI::BLUE === "\033[34m");
    test(ANSI::MAGENTA === "\033[35m");
    test(ANSI::CYAN === "\033[36m");
    test(ANSI::WHITE === "\033[37m");
    test(ANSI::GRAY === "\033[90m");
    test(ANSI::RESET === "\033[0m");
});

Command::main(function () {
    $this->formatted("\n<warning>Testing: XML_ANSI Interface</warning>");

    test(XML_ANSI::INFO === ANSI::GREEN);
    test(XML_ANSI::WARNING === ANSI::YELLOW);
    test(XML_ANSI::ERROR === ANSI::RED);
    test(XML_ANSI::COMMENT === ANSI::GRAY);
    test(XML_ANSI::RESET === ANSI::RESET);
});

Command::main(function () {
    $this->formatted("\n<warning>Testing: WritesToConsole</warning>");

    $this->line('---------');
    $this->write('write');
    $this->line('line');
    $this->info('info');
    $this->warning('warning');
    $this->error('error');
    $this->formatted('formatted');
    $this->line('---------');
});

exit(TestCase::stop());

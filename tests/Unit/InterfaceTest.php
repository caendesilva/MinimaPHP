<?php

it('checks Minima interface constant VERSION', function () {
    expect(Minima::VERSION)->toBe('v0.1.0-dev');
});

test('Minima interface has a VERSION constant', function () {
    $this->assertTrue(defined(Minima::class . '::VERSION'));
});

test('Minima interface VERSION is a string', function () {
    $this->assertIsString(Minima::VERSION);
});

test('Minima interface VERSION is equal to "v0.1.0-dev"', function () {
    $this->assertSame('v0.1.0-dev', Minima::VERSION);
});

it('checks Console interface constant INPUT', function () {
    expect(Console::INPUT)->toBe(STDIN);
});

it('checks Console interface constant OUTPUT', function () {
    expect(Console::OUTPUT)->toBe(STDOUT);
});

test('Console interface has an INPUT constant', function () {
    $this->assertTrue(defined(Console::class . '::INPUT'));
});

test('Console interface INPUT is equal to STDIN', function () {
    $this->assertSame(STDIN, Console::INPUT);
});

test('Console interface has an OUTPUT constant', function () {
    $this->assertTrue(defined(Console::class . '::OUTPUT'));
});

test('Console interface OUTPUT is equal to STDOUT', function () {
    $this->assertSame(STDOUT, Console::OUTPUT);
});

test('ANSI interface has a BLACK constant', function () {
    $this->assertSame("\033[30m", ANSI::BLACK);
});

test('ANSI interface has a RED constant', function () {
    $this->assertSame("\033[31m", ANSI::RED);
});

test('ANSI interface has a GREEN constant', function () {
    $this->assertSame("\033[32m", ANSI::GREEN);
});

test('ANSI interface has a YELLOW constant', function () {
    $this->assertSame("\033[33m", ANSI::YELLOW);
});

test('ANSI interface has a BLUE constant', function () {
    $this->assertSame("\033[34m", ANSI::BLUE);
});

test('ANSI interface has a MAGENTA constant', function () {
    $this->assertSame("\033[35m", ANSI::MAGENTA);
});

test('ANSI interface has a CYAN constant', function () {
    $this->assertSame("\033[36m", ANSI::CYAN);
});

test('ANSI interface has a WHITE constant', function () {
    $this->assertSame("\033[37m", ANSI::WHITE);
});

test('ANSI interface has a GRAY constant', function () {
    $this->assertSame("\033[90m", ANSI::GRAY);
});

test('ANSI interface has a RESET constant', function () {
    $this->assertSame("\033[0m", ANSI::RESET);
});

test('ANSI_EXT interface has a BRIGHT_RED constant', function () {
    $this->assertSame("\033[91m", ANSI_EXT::BRIGHT_RED);
});

test('ANSI_EXT interface has a BRIGHT_GREEN constant', function () {
    $this->assertSame("\033[92m", ANSI_EXT::BRIGHT_GREEN);
});

test('ANSI_EXT interface has a BRIGHT_YELLOW constant', function () {
    $this->assertSame("\033[93m", ANSI_EXT::BRIGHT_YELLOW);
});

test('ANSI_EXT interface has a BRIGHT_BLUE constant', function () {
    $this->assertSame("\033[94m", ANSI_EXT::BRIGHT_BLUE);
});

test('ANSI_EXT interface has a BRIGHT_MAGENTA constant', function () {
    $this->assertSame("\033[95m", ANSI_EXT::BRIGHT_MAGENTA);
});

test('ANSI_EXT interface has a BRIGHT_CYAN constant', function () {
    $this->assertSame("\033[96m", ANSI_EXT::BRIGHT_CYAN);
});

test('ANSI_EXT interface has a BRIGHT_WHITE constant', function () {
    $this->assertSame("\033[97m", ANSI_EXT::BRIGHT_WHITE);
});

test('XML_ANSI interface has an INFO constant', function () {
    $this->assertSame(ANSI::GREEN, XML_ANSI::INFO);
});

test('XML_ANSI interface has a WARNING constant', function () {
    $this->assertSame(ANSI::YELLOW, XML_ANSI::WARNING);
});

test('XML_ANSI interface has an ERROR constant', function () {
    $this->assertSame(ANSI::RED, XML_ANSI::ERROR);
});

test('XML_ANSI interface has a COMMENT constant', function () {
    $this->assertSame(ANSI::GRAY, XML_ANSI::COMMENT);
});

test('XML_ANSI interface has a RESET constant', function () {
    $this->assertSame(ANSI::RESET, XML_ANSI::RESET);
});

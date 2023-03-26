<?php

it('checks Minima interface constant VERSION', function () {
    expect(Minima::VERSION)->toBe('v0.1.0-dev');
});

it('checks Console interface constant INPUT', function () {
    expect(Console::INPUT)->toBe(STDIN);
});

it('checks Console interface constant OUTPUT', function () {
    expect(Console::OUTPUT)->toBe(STDOUT);
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

<?php

test('options', fn() => main(function () {
    expect($this->options)->toBeArray();
}));

test('arguments', fn() => main(function () {
    expect($this->arguments)->toBeArray();
}));

test('options method', fn() => main(function () {
    expect($this->options())->toBe($this->options);
}));

test('arguments method', fn() => main(function () {
    expect($this->arguments())->toBe($this->arguments);
}));

test('has option', fn() => main(function () {
    expect($this->hasOption('foo'))->toBeFalse();
}));

test('has argument', fn() => main(function () {
    expect($this->hasArgument('foo'))->toBeFalse();
}));

test('get option', fn() => main(function () {
    expect($this->getOption('foo'))->toBeNull();
}));

test('get argument', fn() => main(function () {
    expect($this->getArgument('foo'))->toBeNull();
}));

test('get option default', fn() => main(function () {
    expect($this->getOption('foo', 'bar'))->toBe('bar');
}));

test('get argument default', fn() => main(function () {
    expect($this->getArgument('foo', 'bar'))->toBe('bar');
}));

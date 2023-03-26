<?php

// GPT Prompt: Write PestPHP unit tests for the code provided below. You should use the `test()` function and the expectation API.

test('Output class writes the string to the output', function () {
    ob_start();
    Output::write('Hello, world!');
    $output = ob_get_clean();
    expect($output)->toBe('Hello, world!');
});

test('WritesToOutput helper methods', function () {
    ob_start();
    $output = new InteractsWithIOClass;
    $output->write('foo');
    $output->write(' ');
    $output->line('foo');
    $output->info('foo');
    $output->warning('foo');
    $output->error('foo');
    expect(ob_get_clean())->toBe('foo foo
[32mfoo[0m
[33mfoo[0m
[31mfoo[0m
');
});

class InteractsWithIOClass {
    use InteractsWithIO;
}

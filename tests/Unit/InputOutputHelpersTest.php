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
    (new InteractsWithIOClass)->write('foo');
    expect(ob_get_clean())->toBe('foo');
});

class InteractsWithIOClass {
    use InteractsWithIO;
}

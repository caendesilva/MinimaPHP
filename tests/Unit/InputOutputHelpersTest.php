<?php

// GPT Prompt: Write PestPHP unit tests for the code provided below. You should use the `test()` function and the expectation API.

test('Output class writes the string to the output', function () {
    ob_start();
    Output::write('Hello, world!');
    $output = ob_get_clean();
    expect($output)->toBe('Hello, world!');
});

test('WritesToOutput::write method writes string to output', function () {
    ob_start();
    WritesToOutputClass::call('write', ['Hello, world!']);
    expect(ob_get_clean())->toBe('Hello, world!');
});

class WritesToOutputClass {
    use WritesToOutput;

    public static function call(string $name, array $arguments)
    {
        return (new static)->$name(...$arguments);
    }
}

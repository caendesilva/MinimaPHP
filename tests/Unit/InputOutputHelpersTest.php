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
    $output->line('line');
    $output->info('info');
    $output->warning('warning');
    $output->error('error');
    expect(ob_get_clean())->toBe('foo line
[32minfo[0m
[33mwarning[0m
[31merror[0m
');
});

test('WritesToOutput XML formatting method', function () {
    ob_start();
    $output = new InteractsWithIOClass;
    $output->formatted('<info>info</info>, <warning>warning</warning>, <error>error</error>, <comment>comment</comment>, <reset>reset</reset>');
    $output->formatted('<red>red</red>, <green>green</green>, <blue>blue</blue>, <yellow>yellow</yellow>, <magenta>magenta</magenta>, <cyan>cyan</cyan>');

    expect(ob_get_clean())->toBe('[32minfo[0m, [33mwarning[0m, [31merror[0m, [90mcomment[0m, [0mreset[0m
[31mred[0m, [32mgreen[0m, [34mblue[0m, [33myellow[0m, [35mmagenta[0m, [36mcyan[0m
');
});

class InteractsWithIOClass {
    use InteractsWithIO;
}

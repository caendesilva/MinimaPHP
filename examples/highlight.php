<?php

require_once 'minima.php';

Command::main(function (): void {
    $this->formatted('<info>Simple console highlighting data dumper</info>');

    $this->line(Dumper::highlight([
        'foo',
        'bar' => 'baz',
        'array' => [
            'some',
            'contents',
            'bool' => true,
            'integer' => 10,
            'deep' => ['array']
        ],
        'object' => new Dumper(),
        'null' => null
    ]));
});

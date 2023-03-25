<?php

require_once 'minima.php';

Command::main(function (): void {
    $this->formatted('<info>Simple console highlighting data dumper</info>');

    $this->line(Dumper::highlight([
        'foo' => 'bar',
        'array' => [
            'some',
            'contents',
            'bool' => true,
            'integer' => 10,
        ],
    ]));
});

class Dumper {
    public static function highlight(mixed $data): string {
        return //
    }
}

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
        if (is_string($data)) {
            return static::string($string);
        }
        if (is_int($data)) {
            return static::int($string);
        }
        if (is_bool($data)) {
            return static::bool($string);
        }
        if (is_array($data)) {
            return static::array($string);
        }
        if (is_object($data)) {
            return $data::class;
        }

        return (string) $data;
    }
}

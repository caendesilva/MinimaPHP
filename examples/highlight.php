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
        ],
    ]));
});

class Dumper {
    public static function highlight(mixed $data): string {
        if (is_null($data)) {
            return static::null($data);
        }
        if (is_string($data)) {
            return static::string($data);
        }
        if (is_int($data)) {
            return static::int($data);
        }
        if (is_bool($data)) {
            return static::bool($data);
        }
        if (is_array($data)) {
            return static::array($data);
        }
        if (is_object($data)) {
            return $data::class;
        }

        return (string) $data;
    }

    protected static function null(null|string $value): string {
        return $value;
    }

    protected static function string(string $value): string {
        return $value;
    }

    protected static function int(int $value): string {
        return $value;
    }

    protected static function bool(bool $value): string {
        return $value;
    }

    protected static function array(array $value): string {
        return $value;
    }
}

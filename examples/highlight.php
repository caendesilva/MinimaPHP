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
        'object' => new Dumper(),
    ]));
});

class Dumper {
    public static int $arrayBreakLevel = 2;

    protected int $indentationLevel = 0;
    protected bool $inOpenArray = false;

    public static function highlight(mixed $data): string {
        return (new static)->runHighlighter($data);
    }

    protected function runHighlighter(mixed $data): string {
        if (is_null($data)) {
            return $this->null($data);
        }
        if (is_string($data)) {
            return $this->string($data);
        }
        if (is_int($data)) {
            return $this->int($data);
        }
        if (is_bool($data)) {
            return $this->bool($data);
        }
        if (is_array($data)) {
            return $this->array($data);
        }
        if (is_object($data)) {
            return $data::class;
        }

        return (string) $data;
    }

    protected function null(null|string $value): string {
        return 'null';
    }

    protected function string(string $value): string {
        return "'$value'";
    }

    protected function int(int $value): string {
        return $value;
    }

    protected function bool(bool $value): string {
        return $value ? 'true' : 'false';
    }

    protected function array(array $array): string {
        $parts = [];
        foreach ($array as $key => $value) {
            if (is_int($key)) {
                $parts[] = $this->runHighlighter($value);
            } else {
                $parts[] = $this->string($key).' => '.$this->runHighlighter($value);
            }
        }
        return '['.implode(', ', $parts).']';
    }
}

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

class Dumper {
    public static int $arrayBreakLevel = 2;

    const INDENT = '  ';

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
        $this->indentationLevel++;
        if ($this->indentationLevel >= static::$arrayBreakLevel -1) {
            $this->inOpenArray = true;
        }
        $parts = [];
        foreach ($array as $key => $value) {
            if ($this->inOpenArray) {
                $indent = str_repeat(self::INDENT, $this->indentationLevel);
            } else {
                $indent = '';
            }
            if (is_int($key)) {
                $parts[] = $indent.$this->runHighlighter($value);
            } else {
                $parts[] = $indent.$this->string($key).' => '.$this->runHighlighter($value);
            }
        }
        if ($this->inOpenArray) {
            $this->indentationLevel--;
            $indent = str_repeat(self::INDENT, $this->indentationLevel);
            return "[\n".implode(",\n", $parts)."\n$indent]";
        } else {
            return '['.implode(', ', $parts).']';
        }
    }
}

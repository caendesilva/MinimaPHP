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

interface Theme {
    const ARRAY_OPEN = ANSI::WHITE.'['.ANSI::RESET;
    const ARRAY_CLOSE = ANSI::WHITE.']'.ANSI::RESET;
    const STRING_OPEN = ANSI::BLUE."'".ANSI::GREEN;
    const STRING_CLOSE = ANSI::BLUE."'".ANSI::RESET;
    const INTEGER_OPEN = ANSI::YELLOW;
    const INTEGER_CLOSE = ANSI::RESET;
    const BOOLEAN_OPEN = ANSI::RED;
    const BOOLEAN_CLOSE = ANSI::RESET;
    const OBJECT_OPEN = ANSI::YELLOW;
    const OBJECT_CLOSE = ANSI::RESET;
    const NULL = ANSI::RED.'null'.ANSI::RESET;
}

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
            return Theme::OBJECT_OPEN .$data::class.Theme::OBJECT_CLOSE;
        }

        return (string) $data;
    }

    protected function null(null|string $value): string {
        return Theme::NULL;
    }

    protected function string(string $value): string {
        return Theme::STRING_OPEN.$value.Theme::STRING_CLOSE;
    }

    protected function int(int $value): string {
        return THEME::INTEGER_OPEN .$value.Theme::INTEGER_CLOSE;
    }

    protected function bool(bool $value): string {
        return Theme::BOOLEAN_OPEN .($value ? 'true' : 'false').Theme::BOOLEAN_CLOSE;
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
            return Theme::ARRAY_OPEN."\n".implode(",\n", $parts)."\n$indent".Theme::ARRAY_CLOSE;
        } else {
            return Theme::ARRAY_OPEN.''.implode(', ', $parts).''.Theme::ARRAY_CLOSE;
        }
    }
}

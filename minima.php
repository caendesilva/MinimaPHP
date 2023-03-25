<?php

interface Minima {
    const VERSION = 'v0.1.0-dev';
}

interface Console {
    const INPUT = STDIN;
    const OUTPUT = STDOUT;
}

interface ANSI {
    const BLACK   = "\033[30m";
    const RED     = "\033[31m";
    const GREEN   = "\033[32m";
    const YELLOW  = "\033[33m";
    const BLUE    = "\033[34m";
    const MAGENTA = "\033[35m";
    const CYAN    = "\033[36m";
    const WHITE   = "\033[37m";
    const GRAY    = "\033[90m";
    const RESET   = "\033[0m";
}

interface XML_ANSI {
    const INFO    = ANSI::GREEN;
    const WARNING = ANSI::YELLOW;
    const ERROR   = ANSI::RED;
    const COMMENT = ANSI::GRAY;
    const RESET   = ANSI::RESET;
}

trait WritesToOutput {
    protected function write(string $string): void {
        Output::write($string);
    }

    protected function line(string $message = ''): void {
        Output::write($message . PHP_EOL);
    }

    protected function info(string $message): void {
        $this->line(XML_ANSI::INFO . $message . ANSI::RESET);
    }

    protected function warning(string $message): void {
        $this->line(XML_ANSI::WARNING . $message . ANSI::RESET);
    }

    protected function error(string $message): void {
        $this->line(XML_ANSI::ERROR . $message . ANSI::RESET);
    }

    protected function formatted(string $message): void {
        $startTags = [
            '<info>' => XML_ANSI::INFO,
            '<warning>' => XML_ANSI::WARNING,
            '<error>' => XML_ANSI::ERROR,
            '<comment>' => XML_ANSI::COMMENT,
            '<reset>' => XML_ANSI::RESET,
        ];

        $endTags = [
            '</info>' => XML_ANSI::RESET,
            '</warning>' => XML_ANSI::RESET,
            '</error>' => XML_ANSI::RESET,
            '</comment>' => XML_ANSI::COMMENT,
            '</reset>' => XML_ANSI::RESET,
            '</>' => XML_ANSI::RESET,
        ];

        $formatted = str_replace(array_keys($startTags), array_values($startTags), $message);
        $formatted = str_replace(array_keys($endTags), array_values($endTags), $formatted);

        $this->line($formatted);
    }

    /** @example $this->line('Hello ' . $this->ask('Name')); */
    protected function ask(string $question, string $default = ''): string {
        return Input::readline(ANSI::YELLOW."$question: ".ANSI::RESET) ?: $default;
    }
}

trait AccessesArguments {
    protected function options(): array {
        return $this->options;
    }

    protected function arguments(): array {
        return $this->arguments;
    }

    protected function hasOption(string $name): bool {
        return isset($this->options[$name]);
    }

    protected function hasArgument(string $name): bool {
        return isset($this->arguments[$name]) || isset(array_flip(array_values($this->arguments))[$name]);
    }

    protected function getOption(string $name, mixed $default = null): mixed {
        return $this->options[$name] ?? $default;
    }

    protected function getArgument(string $name, mixed $default = null): mixed {
        return $this->arguments[$name] ?? $this->getArgumentByValue($name) ?? $default;
    }

    private function getArgumentByValue(string $value): ?string {
        $index = array_flip(array_values($this->arguments))[$value] ?? null;
        return $this->arguments[$index] ?? null;
    }

    private static function parseOptions(array $options): array {
        $formatted = [];
        foreach ($options as $index => $option) {
            $option = ltrim($option, '-');
            if (str_contains($option, '=')) {
                $parts = explode('=', $option);
                $formatted[$parts[0]] = $parts[1];
            } else {
                $formatted[$option] = true;
            }
        }
        return $formatted;
    }

    private static function parseArguments(array $arguments): array {
        $formatted = [];
        foreach ($arguments as $index => $argument) {
            if (str_contains($argument, '=')) {
                $parts = explode('=', $argument);
                $formatted[$parts[0]] = $parts[1];
            } else {
                $formatted[$index] = $argument;
            }
        }
        return $formatted;
    }

    private static function parseCommandArguments(): array {
        global $argc;
        global $argv;

        $options = [];
        $arguments = [];

        for($i = 1; $i < $argc; $i++) {
            if (str_starts_with($argv[$i], '-')) {
                $options[] = $argv[$i];
            } else {
                $arguments[] = $argv[$i];
            }
        }

        return array(self::parseOptions($options), self::parseArguments($arguments));
    }
}

class Output {
    public static function write(string $string): void {
        file_put_contents('php://stdout', $string);
    }

    public static function line(string $message = ''): void {
        static::write($message . PHP_EOL);
    }
}

class Input {
    public static function readline(?string $prompt = null): string {
        return readline($prompt);
    }

    public static function getline(): string {
        return trim(fgets(Console::INPUT));
    }
}

class Command {
    use WritesToOutput;
    use AccessesArguments;

    protected Output $output;

    protected array $options;
    protected array $arguments;

    protected function __construct() {
        $this->output = new Output();

        list($this->options, $this->arguments) = $this->parseCommandArguments();
    }

    public static function main(Closure $logic): int {
        $command = new static();

        $logic = $logic->bindTo($command, static::class);

        return $logic() ?? 0;
    }
}



class Dumper {
    public static int $arrayBreakLevel = 2;

    const INDENT = '  ';
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
            return static::OBJECT_OPEN .$data::class.static::OBJECT_CLOSE;
        }

        return (string) $data;
    }

    protected function null(null|string $value): string {
        return static::NULL;
    }

    protected function string(string $value): string {
        return static::STRING_OPEN.$value.static::STRING_CLOSE;
    }

    protected function int(int $value): string {
        return static::INTEGER_OPEN .$value.static::INTEGER_CLOSE;
    }

    protected function bool(bool $value): string {
        return static::BOOLEAN_OPEN .($value ? 'true' : 'false').static::BOOLEAN_CLOSE;
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
            return static::ARRAY_OPEN."\n".implode(",\n", $parts)."\n$indent".static::ARRAY_CLOSE;
        } else {
            return static::ARRAY_OPEN.''.implode(', ', $parts).''.static::ARRAY_CLOSE;
        }
    }
}

if (! function_exists('main')) {
    function main(Closure $logic): int {
        return Command::main($logic);
    }
}

if (! function_exists('dump')) {
    function dump(mixed $value): void {
        var_dump($value);
    }
}

if (! function_exists('dd')) {
    function dd(mixed $value): never {
        dump($value);
        die(1);
    }
}

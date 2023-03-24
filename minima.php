<?php

interface Minima {
    const VERSION = 'v0.1.0-dev';
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

trait WritesToConsole {
    protected function write(string $string): void {
        Console::write($string);
    }

    protected function line(string $message = ''): void {
        Console::write($message . PHP_EOL);
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
    protected function ask(string $question): string {
        return Input::readline(ANSI::YELLOW."$question: ".ANSI::RESET);
    }
}

class Console {
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
        return trim(fgets(STDIN));
    }
}

class Command {
    use WritesToConsole;

    protected Console $console;

    protected array $options;
    protected array $arguments;

    protected function __construct() {
        $this->console = new Console();

        list($this->options, $this->arguments) = $this->parseArguments();
    }

    public static function main(Closure $logic): int {
        $command = new static();

        $logic = $logic->bindTo($command, static::class);

        return $logic() ?? 0;
    }

    private function parseArguments(): array {
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

        return array($options, $arguments);
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

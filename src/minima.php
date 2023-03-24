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
    const RESET   = "\033[0m";
}

trait WritesToConsole {
	protected function write(string $string): void {
	    Console::write($string);
	}

	protected function line(string $message = ''): void {
        Console::write($message . PHP_EOL);
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

class Command {
	use WritesToConsole;

	protected Console $console;

	protected array $options;
	protected array $arguments;

	protected function __construct() {
		$this->console = new Console();
	}

	public static function main(Closure $logic): int {
		$command = new static();

		$logic = $logic->bindTo($command, static::class);

		return $logic($command) ?? 0;
	}
}

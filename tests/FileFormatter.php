<?php

require_once __DIR__ . '/../minima.php';

Command::main(function () {
    $this->info('Formatting files!');

    $directories = [
        __DIR__ . '/../tests',
        __DIR__ . '/../examples'
    ];

    $allFiles = [];
    $files = glob(__DIR__ . '/../*.php', GLOB_BRACE);

    foreach ($files as $file) {
        if (is_file($file)) {
            $allFiles[] = $file;
        }
    }

    foreach ($directories as $dir) {
        $files = glob($dir . '/**/*', GLOB_BRACE);

        foreach ($files as $file) {
            if (is_file($file)) {
                $allFiles[] = $file;
            }
        }

        $files = glob($dir . '/*', GLOB_BRACE);

        foreach ($files as $file) {
            if (is_file($file)) {
                $allFiles[] = $file;
            }
        }
    }

    $files = $allFiles;

    foreach ($files as $file) {
        $this->line("Formatting ".basename($file));
        formatFile($file);
    }
});

function formatFile(string $file): void {
    $contents = str_replace("\r\n", "\n", file_get_contents($file));
    $contents = str_replace("\t", "    ", $contents);

    $lines = explode("\n", $contents);

    foreach ($lines as $index => $line) {
        $lines[$index] = rtrim($line);
    }
    file_put_contents($file, implode("\n", $lines));
}

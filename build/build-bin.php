<?php

require_once __DIR__.'/../minima.php';

$exitCode = Command::main(function (): void {
    $this->info('Building binary!');

    $src = file_get_contents(__DIR__.'/../minima.php');
    $base = file_get_contents(__DIR__.'/dev-bin');

    $src = str_replace("<?php", "// start minima.php", $src);
    $bin = str_replace("require_once __DIR__.'/../minima.php';", $src . "\n// end minima.php", $base);

    if (isFileChanged($bin, file_get_contents(__DIR__.'/../bin/minima'))) {
        $this->info('No changes made since last build. Exiting gracefully.');
        return;
    }

    $shortSha = trim(shell_exec('git rev-parse --short HEAD'));
    $bin = str_replace("const REVISION = 'dev'", "const REVISION = '$shortSha'", $bin);

    file_put_contents(__DIR__.'/../bin/minima', $bin);

    if ($this->hasOption('git')) {
        $this->info('Making Git commit');
        passthru('git add bin/minima && git commit -m "Build standalone executable" -m "SHA256 Checksum: '.hash('sha256', $bin).'"');
    }

    $this->info('All done!');
});

function isFileChanged(string $new, string $old): bool {
    $unsetRevisionLines = function(string $contents): string {
        $lines = explode("\n", $contents);
        foreach ($lines as $index => $line) {
            if (str_contains($line, 'const REVISION = ')) {
                unset($lines[$index]);
                break;
            }
        }
        return implode("\n", $lines);
    };

    return $unsetRevisionLines($new) === $unsetRevisionLines($old);
}

exit($exitCode);

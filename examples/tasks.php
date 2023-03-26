<?php

require_once 'minima.php';

Command::main(function (): void {
    $runTasks = $this->hasOption('skip-tasks') || $this->hasOption('s');

    if (! $runTasks) {
        putenv('SKIP_TASKS=true');
    }

    $taskMessage = $runTasks ? "remove `--skip-tasks` to run the tasks" : "pass `--skip-tasks` to skip the tasks";
    $this->formatted("<info>Tasks example</info> - <yellow>$taskMessage</yellow>");

    task('myTask', function () {
        $this->line('Called from the task!');        
    });
});

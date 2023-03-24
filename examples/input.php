<?php

require_once 'minima.php';

Command::main(function () {
    $this->info('What is your name?');
    $this->line('Hello ' . $this->ask('My name is') . '!');
});

# MinimaPHP

Minimal PHP micro-framework for creating general purpose command-line scripts

## Installation

Copy the `minima.php` file to your project, include it from your main script. You're done.

## Usage

Write your logic in a closure through the `Command::main()` method or the `main()` function. You will then be able to access all the helpers through the `$this` variable.

```php
<?php

require_once 'minima.php';

Command::main(function (): void {
    $this->info('Welcome to MinimaPHP!');
});
```


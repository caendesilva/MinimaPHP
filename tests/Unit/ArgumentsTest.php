<?php

test('options', function () {
    Command::main(function () {
        expect($this->options)->toBeArray();
    });
});

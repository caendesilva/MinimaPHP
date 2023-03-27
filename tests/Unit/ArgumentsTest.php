<?php

test('options', fn() => main(function () {
    expect($this->options)->toBeArray();
}));

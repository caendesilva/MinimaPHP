<?php

test('options', function () {
    main(function () {
        expect($this->options)->toBeArray();
    });
});

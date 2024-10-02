<?php

declare(strict_types=1);

use function Pest\Laravel\get;

it('show welcome page', function () {
    get('/')
        ->assertSuccessful();
});

<?php

declare(strict_types=1);

arch('actions test')
    ->expect('App\Actions')
    ->toBeClasses()
    ->toBeFinal()
    ->toBeReadonly()
    ->toUseStrictTypes()
    ->toHaveSuffix('Action');

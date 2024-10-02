<?php

declare(strict_types=1);

namespace Fabpl\Starter;

use Fabpl\Starter\Console\Commands\InstallCommand;
use Illuminate\Support\ServiceProvider;

final class StarterServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->commands([
            InstallCommand::class,
        ]);
    }
}

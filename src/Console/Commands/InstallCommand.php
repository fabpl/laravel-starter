<?php

declare(strict_types=1);

namespace Fabpl\Starter\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use RuntimeException;
use Symfony\Component\Process\PhpExecutableFinder;
use Symfony\Component\Process\Process;

final class InstallCommand extends Command
{
    protected $signature = 'starter:install
                            {--composer=global : Absolute path to the Composer binary which should be used to install packages}';

    protected $description = 'Install the starter';

    public function handle(): int
    {
        $this->info('Installing starter...');

        if (! $this->requireComposerDevPackages([
            'fabpl/laravel-preset',
        ])) {
            return self::FAILURE;
        }

        if (! $this->requireComposerPackages([
            'filament/filament',
            'gehrisandro/tailwind-merge-laravel',
            'laravel/folio',
            'livewire/livewire',
            'livewire/volt',
            'themesberg/flowbite-blade-icons',
        ])) {
            return self::FAILURE;
        }

        $this->runCommands([
            'php artisan preset:install',
            'php artisan folio:install',
            'php artisan volt:install',
        ]);

        $this->updateNodePackages(function ($packages) {
            return [
                '@alpinejs/focus' => '^3.14.1',
                '@awcodes/alpine-floating-ui' => '^3.6.3',
                '@tailwindcss/forms' => '^0.5.9',
                '@tailwindcss/typography' => '^0.5.15',
                'alpinejs-notify' => '^1.0.4',
                'autoprefixer' => '^10.4.20',
                'postcss' => '^8.4.47',
                'tailwindcss' => '^3.4.13',
            ] + $packages;
        });

        $filesystem = new Filesystem;

        $filesystem->copyDirectory(__DIR__.'/../../../stubs', base_path());

        if (file_exists(base_path('pnpm-lock.yaml'))) {
            $this->runCommands(['pnpm install', 'pnpm run build']);
        } elseif (file_exists(base_path('yarn.lock'))) {
            $this->runCommands(['yarn install', 'yarn run build']);
        } else {
            $this->runCommands(['npm install', 'npm run build']);
        }

        $this->info('Starter has been installed!');

        return self::SUCCESS;
    }

    /**
     * Update the "package.json" file.
     */
    private static function updateNodePackages(callable $callback, bool $dev = true): void
    {
        if (! file_exists(base_path('package.json'))) {
            return;
        }

        $configurationKey = $dev ? 'devDependencies' : 'dependencies';

        $packages = json_decode(file_get_contents(base_path('package.json')), true);

        $packages[$configurationKey] = $callback(
            array_key_exists($configurationKey, $packages) ? $packages[$configurationKey] : [],
            $configurationKey
        );

        ksort($packages[$configurationKey]);

        file_put_contents(
            base_path('package.json'),
            json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT).PHP_EOL
        );
    }

    /**
     * Get the path to the appropriate PHP binary.
     */
    private function phpBinary(): string
    {
        return (new PhpExecutableFinder)->find(false) ?: 'php';
    }

    /**
     * Install the given Composer Packages as "dev" dependencies.
     */
    private function requireComposerDevPackages(array $packages): bool
    {
        $composer = $this->option('composer');

        if ($composer !== 'global') {
            $command = [$this->phpBinary(), $composer, 'require', '--dev'];
        }

        $command = array_merge(
            $command ?? ['composer', 'require', '--dev'],
            $packages
        );

        return (new Process($command, base_path(), ['COMPOSER_MEMORY_LIMIT' => '-1']))
            ->setTimeout(null)
            ->run(function ($type, $output) {
                $this->output->write($output);
            }) === 0;
    }

    /**
     * Install the given Composer Packages.
     */
    private function requireComposerPackages(array $packages): bool
    {
        $composer = $this->option('composer');

        if ($composer !== 'global') {
            $command = [$this->phpBinary(), $composer, 'require'];
        }

        $command = array_merge(
            $command ?? ['composer', 'require'],
            $packages
        );

        return (new Process($command, base_path(), ['COMPOSER_MEMORY_LIMIT' => '-1']))
            ->setTimeout(null)
            ->run(function ($type, $output) {
                $this->output->write($output);
            }) === 0;
    }

    /**
     * Run the given commands.
     */
    private function runCommands(array $commands): void
    {
        $process = Process::fromShellCommandline(implode(' && ', $commands), null, null, null, null);

        if ('\\' !== DIRECTORY_SEPARATOR && file_exists('/dev/tty') && is_readable('/dev/tty')) {
            try {
                $process->setTty(true);
            } catch (RuntimeException $e) {
                $this->output->writeln('  <bg=yellow;fg=black> WARN </> '.$e->getMessage().PHP_EOL);
            }
        }

        $process->run(function ($type, $line) {
            $this->output->write('    '.$line);
        });
    }
}

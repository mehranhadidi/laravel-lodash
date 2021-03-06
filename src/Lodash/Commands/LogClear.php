<?php
/*
 * This file is part of the Laravel Lodash package.
 *
 * (c) Avtandil Kikabidze aka LONGMAN <akalongman@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Longman\LaravelLodash\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Console\ConfirmableTrait;

class LogClear extends Command
{
    use ConfirmableTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'log:clear {--force : Force the operation to run when in production.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear log files';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (! $this->confirmToProceed('Application In Production! Will be deleted all log files!')) {
            return;
        }

        $filesystem = app(Filesystem::class);

        $logFiles = $filesystem->glob(storage_path('logs/*.log'));

        foreach ($logFiles as $file) {
            $status = $filesystem->delete($file);
            if ($status) {
                $this->info('Successfully deleted: ' . $file);
            }
        }
    }

}

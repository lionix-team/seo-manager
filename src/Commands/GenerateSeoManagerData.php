<?php

namespace Lionix\SeoManager\Commands;

use Illuminate\Console\Command;
use Lionix\SeoManager\Models\SeoManager;
use Lionix\SeoManager\Traits\SeoManagerTrait;

class GenerateSeoManagerData extends Command
{
    use SeoManagerTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seo-manager:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fill Seo Manager database table with routes data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Import Started');
        $this->importRoutes();
        $this->info('Import Finished');
    }
}

<?php

namespace WPTL\Console\Commands;

use Illuminate\Console\Command;

class ImportWpMedia extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:wp-media';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download All Media from WordPress.';

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
        // get all files under storage/wp with prefix media
    }
}

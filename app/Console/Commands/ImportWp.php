<?php

namespace WPTL\Console\Commands;

use Illuminate\Console\Command;

class ImportWp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:wp {domain}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import WordPress User, Post, Category, Tag, and Media.';

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
        $domain = $this->argument('domain') . '/wp-json/wp/v2/';

        collect(['posts', 'pages', 'categories', 'tags', 'media'])->each(function ($fetch) use ($domain) {
            \WPTL\Services\WordPress::make($domain)->setUri($fetch)->handle();
        });
    }
}

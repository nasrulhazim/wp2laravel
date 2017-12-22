<?php

namespace WPTL\Console\Commands;

use Illuminate\Console\Command;

class ImportWpSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:wp-sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync from JSON file to database.';

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
        $path        = storage_path('wp/posts_*.json');
        $grand_total = 0;
        $count       = 1;
        foreach (glob($path) as $filename) {
            $posts       = json_decode(file_get_contents($filename));
            $total       = count($posts);
            $grand_total = $grand_total + $total;
            foreach ($posts as $post) {
                $this->comment('Processing: (' . $count . ') ' . html_entity_decode($post->title->rendered));
                \WPTL\Processors\WordPress\SyncPost::make($post)->handle();
                $count++;
            }
        }
        $this->info('TOTAL POSTS: ' . $grand_total);
    }
}

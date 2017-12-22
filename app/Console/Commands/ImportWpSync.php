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
        collect(['tags', 'categories', 'media', 'comments', 'posts'])->each(function ($type) {
            $path        = storage_path('wp/' . $type . '_*.json');
            $grand_total = 0;
            $count       = 1;
            foreach (glob($path) as $filename) {
                $records     = json_decode(file_get_contents($filename));
                $total       = count($records);
                $grand_total = $grand_total + $total;
                foreach ($records as $record) {
                    $this->comment('Processing: (' . $count . ') ');
                    $class_name = '\WPTL\Processors\WordPress\Sync' . studly_case(str_singular($type));
                    if (class_exists($class_name)) {
                        $class_name::make($record)->handle();
                    }
                    $count++;
                }
            }
            $this->info('TOTAL ' . strtoupper($type) . ': ' . $grand_total);
        });
    }
}

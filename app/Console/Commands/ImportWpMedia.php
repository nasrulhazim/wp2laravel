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
    protected $signature = 'import:wp-media {domain}';

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
        $domain = $this->argument('domain');
        // get all files under storage/wp with prefix media
        $path = storage_path('wp/media_*.json');
        foreach (glob($path) as $filename) {
            $medias = json_decode(file_get_contents($filename));
            $this->info($filename);
            foreach ($medias as $media) {
                $source_url = $media->guid->rendered;
                $explode    = explode('/', $source_url);
                $medianame  = $explode[count($explode) - 1];
                $uri        = str_replace($domain, '', $source_url);
                $path       = str_replace($medianame, '', $uri);
                $this->comment('Downloading: ' . $medianame);
                \WPTL\Services\WordPress\DownloadMedia::make($domain)
                    ->setUri($uri)
                    ->setFilePath($path)
                    ->setFilename($medianame)
                    ->handle();
            }
        }
    }
}

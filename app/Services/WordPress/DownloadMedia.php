<?php

namespace WPTL\Services\WordPress;

use Illuminate\Filesystem\Filesystem;
use WPTL\Traits\HasWordPressService;

/**
 * DownloadMedia Service
 */
class DownloadMedia
{
    use HasWordPressService;

    /**
     * Create a new controller creator command instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $files
     * @return void
     */
    public function __construct($domain)
    {
        $this->domain = $domain;
        $this->files  = new Filesystem;
    }

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * Filename
     * @var string
     */
    protected $filename;

    /**
     * FilePath
     * @var string
     */
    protected $filePath;

    /**
     * Set filename
     * @param string
     * @return $this
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
        return $this;
    }

    /**
     * Get filename
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Set File Path
     * @param string
     * @return $this
     */
    public function setFilePath($filePath)
    {
        $this->filePath = $filePath;
        return $this;
    }

    /**
     * Get File Path
     * @return string
     */
    public function getFilePath()
    {
        return storage_path('app/public' . $this->filePath . $this->getFilename());
    }

    /**
     * Build the directory for the class if necessary.
     *
     * @param  string  $path
     * @return string
     */
    protected function makeDirectory($path)
    {
        if (!$this->files->isDirectory(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0777, true, true);
        }

        return $path;
    }

    /**
     * Handle the processing
     *
     * @return void
     */
    public function handle()
    {
        $this->makeDirectory($this->getFilePath());
        $this->getDownloadRequest($this->getFilePath());
    }
}

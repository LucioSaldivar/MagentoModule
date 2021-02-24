<?php
namespace Lucio\FileProcessor\Cron;

use Lucio\FileProcessor\Api\Data\FileInterface;
use Lucio\FileProcessor\Api\Data\FileSearchResultsInterface;
use Lucio\FileProcessor\Api\FileRepositoryInterface;
use Lucio\FileProcessor\Helper\Config;
use Lucio\FileProcessor\Logger\Logger;
use Lucio\FileProcessor\Model\File\Config as FileConfig;
use Magento\Framework\Filesystem\Io\File;

class Checker
{
    protected $logger;

    protected $fileConfig;

    public function __construct(
        Logger $logger,
        FileConfig $fileConfig
    ) {
        $this->logger = $logger;
        $this->fileConfig = $fileConfig;
    }

    public function execute()
    {
        $this->logger->info("heartbeat");

        return $this;
    }
}

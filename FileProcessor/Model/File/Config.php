<?php
namespace Lucio\FileProcessor\Model\File;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Filesystem;

class Config
{
    protected $storeManager;

    protected $filesystem;

    public function __construct(StoreManagerInterface $storeManager, Filesystem $filesystem)
    {
        $this->storeManager = $storeManager;
        $this->filesystem = $filesystem;
    }

    public function getBaseFilePath()
    {
        return 'lucio/fileprocessor';
    }

    public function getTmpFileUrl($file)
    {
        $baseUrl = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
        return $baseUrl . $this->getBaseTmpMediaPath() . '/' . $this->_prepareFile($file);
    }

    public function getFileUrl($file)
    {
        $baseUrl = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
        return $baseUrl . $this->getBaseFilePath() . '/' . $this->_prepareFile($file);
    }

    public function getBaseTmpFilePath()
    {
        return 'tmp/' . $this->getBaseFilePath();
    }

    public function getAbsoluteBaseTmpFilePath()
    {
        $read = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA);
        return $read->getAbsolutePath($this->getBaseTmpFilePath());
    }

    public function getAbsoluteBaseFilePath()
    {
        $read = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA);
        return $read->getAbsolutePath($this->getBaseFilePath());
    }

    public function addFilenameExtra($filename, $extra, $extension = null)
    {
        $pathinfo = pathinfo($filename);
        $extension = $extension ?: $pathinfo['extension'];
        return $pathinfo['dirname'] . DIRECTORY_SEPARATOR . $pathinfo['filename'] . $extra . "." . $extension;
    }

    protected function _prepareFile($file)
    {
        return ltrim(str_replace('\\', '/', $file), '/');
    }


}

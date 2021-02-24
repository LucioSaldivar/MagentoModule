<?php
namespace Lucio\FileProcessor\Model\ResourceModel\File;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Lucio\FileProcessor\Model\File;
use Lucio\FileProcessor\Api\Data\FileInterface;
use Lucio\FileProcessor\Model\ResourceModel\File as ResourceFile;

class Collection extends AbstractCollection
{
    protected $_idFieldName = FileInterface::ENTITY_ID;
    protected $_eventPrefix = "lucio_fileprocessor_collection";
    protected $_eventObject = "file_collection";

    protected function _construct()
    {
        $this->_init(File::class,ResourceFile::class);
    }
}

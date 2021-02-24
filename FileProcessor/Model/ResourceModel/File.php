<?php

namespace Lucio\FileProcessor\Model\ResourceModel;

use Lucio\FileProcessor\Api\Data\FileInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class File extends AbstractDb
{
    protected function _construct()
    {
        $this->_init(FileInterface::DB_MAIN_TABLE, FileInterface::ENTITY_ID);
    }
}

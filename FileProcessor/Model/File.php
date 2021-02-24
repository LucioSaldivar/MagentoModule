<?php

namespace Lucio\FileProcessor\Model;

use Lucio\FileProcessor\Api\Data\FileInterface;
use Magento\Framework\Model\AbstractModel;

class File extends AbstractModel implements FileInterface
{
    protected function _construct()
    {
        $this->_init(ResourceModel\File::class);
    }

    public function getKey()
    {
        return $this->_getData(FileInterface::KEY);
    }
    public function setKey($key)
    {
        return $this->setData(FileInterface::KEY,$key);
    }

    public function getName()
    {
        return $this->_getData(FileInterface::NAME);
    }
    public function setName($name)
    {
        return $this->setData(FileInterface::NAME,$name);
    }

    public function getFileType()
    {
        return $this->_getData(FileInterface::FILE_TYPE);
    }
    public function setFileType($file_type)
    {
        return $this->setData(FileInterface::FILE_TYPE,$file_type);
    }

    public function getDescription()
    {
        return $this->_getData(FileInterface::DESCRIPTION);
    }
    public function setDescription($description)
    {
        return $this->setData(FileInterface::DESCRIPTION,$description);
    }

    public function getOriginLocation()
    {
        return $this->_getData(FileInterface::ORIGIN_LOCATION);
    }
    public function setOriginLocation($origin_location)
    {
        return $this->setData(FileInterface::ORIGIN_LOCATION, $origin_location);
    }

    public function getCreatedAt()
    {
        return $this->_getData(FileInterface::CREATED_AT);
    }
    public function setCreatedAt($created_at)
    {
        return $this->setData(FileInterface::CREATED_AT,$created_at);
    }
}

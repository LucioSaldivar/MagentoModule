<?php
namespace Lucio\FileProcessor\Api;

use Lucio\FileProcessor\Api\Data\FileInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface FileRepositoryInterface
{
    public function save(FileInterface $file);

    public function getById($fileId);

    public function getByKey($key);

    public function existByKey($key);

    public function getList(SearchCriteriaInterface $searchCriteria);
}

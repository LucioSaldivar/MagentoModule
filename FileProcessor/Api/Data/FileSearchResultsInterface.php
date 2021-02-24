<?php
namespace Lucio\FileProcessor\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface FileSearchResultsInterface extends SearchResultsInterface
{
    /**
     * @return FileInterface[]
     */
    public function getItems();

    /**
     * @param FileInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

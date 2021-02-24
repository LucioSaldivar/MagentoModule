<?php
namespace Lucio\FileProcessor\Model;

use Lucio\FileProcessor\Api\Data\FileInterface;
use Lucio\FileProcessor\Api\FileRepositoryInterface;
use Lucio\FileProcessor\Api\Data\FileSearchResultsInterfaceFactory;
use Lucio\FileProcessor\Model\ResourceModel\File as FileResource;
use Lucio\FileProcessor\Model\ResourceModel\File\CollectionFactory;
use Magento\Framework\Api\FilterFactory;
use Magento\Framework\Api\Search\FilterGroupFactory;
use Magento\Framework\Api\SearchCriteriaFactory;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Model\AbstractModel;

class FileRepository implements FileRepositoryInterface
{
    private $resource;

    private $fileFactory;

    private $fileCollectionFactory;

    private $collectionProcessor;

    private $searchResultsFactory;

    private $searchCriteriaFactory;

    private $filterFactory;

    private $filterGroupFactory;

    public function __construct(
        FileResource $resource,
        FileFactory $fileFactory,
        CollectionFactory $fileCollectionFactory,
        CollectionProcessorInterface $collectionProcessor,
        FileSearchResultsInterfaceFactory $searchResultsFactory,
        SearchCriteriaFactory $searchCriteriaFactory,
        FilterFactory $filterFactory,
        FilterGroupFactory $filterGroupFactory
    ) {
        $this->resource = $resource;
        $this->fileFactory = $fileFactory;
        $this->fileCollectionFactory = $fileCollectionFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->searchCriteriaFactory = $searchCriteriaFactory;
        $this->filterFactory = $filterFactory;
        $this->filterGroupFactory = $filterGroupFactory;
    }

    public function save(FileInterface $file)
    {
        try {
            /** @var AbstractModel $file */
            $this->resource->save($file);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__('Could not save the file: %1', $exception->getMessage()), $exception);
        }
        return $file;
    }

    public function getById($fileId)
    {
        $file = $this->fileFactory->create();
        $this->resource->load($file, $fileId);
        if (!$file->getId()) {
            throw new NoSuchEntityException(__('File with id "%1" does not exist.', $fileId));
        }
        return $file;
    }

    public function getByKey($key)
    {
        $filter = $this->filterFactory->create()
            ->setField(FileInterface::KEY)
            ->setValue($key)
            ->setConditionType('eq');

        $filterGroup = $this->filterGroupFactory->create()
            ->setFilters([$filter]);

        $searchCriteria = $this->searchCriteriaFactory->create()
            ->setFilterGroups([$filterGroup])
            ->setPageSize(1);

        $items = $this->getList($searchCriteria)->getItems();

        if( count($items) === 0 ) {
            throw new NoSuchEntityException(__('File with key "%1" does not exist.', $key));
        }

        return array_values($items)[0];
    }

    public function existByKey($key)
    {
        try {
            $this->getByKey($key);
            return true;
        } catch (NoSuchEntityException $e) {
            return false;
        }
    }

    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->fileCollectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }
}

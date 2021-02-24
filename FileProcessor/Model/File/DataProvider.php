<?php
namespace Lucio\FileProcessor\Model\File;

use Lucio\FileProcessor\Model\ResourceModel\File\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;

class DataProvider extends AbstractDataProvider
{
    protected $dataPersistor;

    protected $loadedData;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $fileCollectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $fileCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        if( isset($this->loadedData) ) {
            return $this->loadedData;
        }
        $files = $this->collection->getItems();
        /** @var $file FileInterface */
        foreach ($files as $file) {
            $this->loadedData[$file->getEntityId()] = $file->getData();
        }

        $data = $this->dataPersistor->get('lucio_fileprocessor');
        if ( !empty($data) ) {
            $file = $this->collection->getNewEmptyItem();
            $file->setData($data);
            $this->loadedData[$file->getEntityId()] = $file->getData();
            $this->dataPersistor->clear('lucio_fileprocessor');
        }

        return $this->loadedData;
    }
}

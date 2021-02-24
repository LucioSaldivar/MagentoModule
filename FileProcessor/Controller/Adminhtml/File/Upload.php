<?php
namespace Lucio\FileProcessor\Controller\Adminhtml\File;

use Lucio\FileProcessor\Model\File\Config;
use Lucio\FileProcessor\Model\File\Uploader;
use Magento\Backend\App\Action;
use Magento\Framework\Controller\Result\RawFactory;
use Magento\Framework\Image\AdapterFactory;

class Upload extends Action
{
    /**
     * @var RawFactory
     */
    protected $resultRawFactory;

    protected $uploader;

    protected $adapterFactory;

    protected $config;

    /**
     * @param Action\Context $context
     * @param RawFactory $resultRawFactory
     * @param Uploader $uploader
     * @param AdapterFactory $adapterFactory
     * @param Config $config
     */
    public function __construct(
        Action\Context $context,
        RawFactory $resultRawFactory,
        Uploader $uploader,
        AdapterFactory $adapterFactory,
        Config $config
    ) {
        parent::__construct($context);
        $this->resultRawFactory = $resultRawFactory;
        $this->uploader = $uploader;
        $this->adapterFactory = $adapterFactory;
        $this->config = $config;
    }

    public function execute()
    {
        try {
            $this->uploader->addValidateCallback('catalog_product_file', $this->adapterFactory->create(), 'validateUploadFile');
            $result = $this->uploader->save($this->config->getAbsoluteBaseTmpFilePath());
            unset($result['tmp_name']);
            unset($result['path']);
            $result['url'] = $this->config->getTmpFileUrl($result['file']);
        } catch (\Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }

        /** @var \Magento\Framework\Controller\Result\Raw $response */
        $response = $this->resultRawFactory->create();
        $response->setHeader('Content-type', 'text/plain');
        $response->setContents(json_encode($result));
        return $response;
    }
}

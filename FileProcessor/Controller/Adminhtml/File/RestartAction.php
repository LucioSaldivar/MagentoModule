<?php
namespace Lucio\FileProcessor\Controller\Adminhtml\File;

use Lucio\FileProcessor\Api\Data\FileInterface;
use Lucio\FileProcessor\Api\FileRepositoryInterface;
use Lucio\FileProcessor\Model\File\Config;
use Lucio\FileProcessor\Model\Data\FileFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Filesystem\Io\File;
use Magento\Framework\Message\ManagerInterface;

class RestartAction extends Action
{
    protected $fileRepository;

    public function __construct(
        Action\Context $context,
        FileRepositoryInterface $fileRepository
    ) {
        parent::__construct($context);
        $this->fileRepository = $fileRepository;
    }

    public function execute()
    {
        $entity_id = $this->getRequest()->getParam('entity_id');
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        /** @var FileInterface $file */
        try {
            $file = $this->fileRepository->getById($entity_id);
            $this->fileRepository->save($file);
            $this->messageManager->addSuccessMessage(__("Restarted", $file->getKey()));
        }catch (\Exception $e){
            $this->messageManager->addSuccessMessage(__("Error Restarting", $file->getKey()));
        }
        return $resultRedirect->setPath('*/*/');
    }
}

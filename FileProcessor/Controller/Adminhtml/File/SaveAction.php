<?php
namespace Lucio\FileProcessor\Controller\Adminhtml\File;

use Lucio\FileProcessor\Api\Data\FileInterface;
use Lucio\FileProcessor\Api\FileRepositoryInterface;
use Lucio\FileProcessor\Model\File\Config;
use Lucio\FileProcessor\Model\FileFactory;
use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Filesystem\Io\File;
use Magento\Framework\Message\ManagerInterface;

class SaveAction extends Action
{

    protected $fileFactory;

    protected $fileRepository;

    protected $config;

    protected $filesystemIo;

    protected $dataPersistor;

    public function __construct(
        Action\Context $context,
        FileFactory $fileFactory,
        FileRepositoryInterface $fileRepository,
        Config $config,
        File $filesystemIo,
        DataPersistorInterface $dataPersistor
    )
    {
        parent::__construct($context);
        $this->fileFactory = $fileFactory;
        $this->fileRepository = $fileRepository;
        $this->config = $config;
        $this->filesystemIo = $filesystemIo;
        $this->dataPersistor = $dataPersistor;
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if( $data ) {
            /** @var FileInterface $file */
            $file = $this->fileFactory->create();
            if( $this->fileRepository->existByKey($data['key']) ) {
                $this->dataPersistor->set('lucio_fileprocessor', $data);
                $this->messageManager->addErrorMessage(__("File Key \"%1\" already exists", $data['key']));

                return $resultRedirect->setPath('*/*/AddAction');
            }
            $originFile = $data['origin_file'][0];
            unset($data['origin_file']);
            $file->setData($data);
            $this->moveFile($originFile['file']);
            $file->setOriginLocation($originFile['file']);
            $this->fileRepository->save($file);
            $this->messageManager->addSuccessMessage(__("Successfully Saved"));

            return $resultRedirect->setPath('*/*/');
        }
        return $resultRedirect->setPath('*/*/');
    }

    private function moveFile($file)
    {
        $src = $this->config->getAbsoluteBaseTmpFilePath() . $file;
        $dest = $this->config->getAbsoluteBaseFilePath() . $file;
        $this->filesystemIo->checkAndCreateFolder(dirname($dest));
        $this->filesystemIo->mv($src, $dest);
    }
}

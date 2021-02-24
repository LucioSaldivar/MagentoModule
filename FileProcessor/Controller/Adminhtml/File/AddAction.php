<?php
namespace Lucio\FileProcessor\Controller\Adminhtml\File;

use Lucio\FileProcessor\Model\FileFactory;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\App\Action;

class AddAction extends Action
{
    protected $fileFactory;

    protected $resultPageFactory;

    public function __construct(
        Action\Context $context,
        PageFactory $resultPageFactory,
        FileFactory $fileFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->fileFactory = $fileFactory;
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('New File'));

        return $resultPage;
    }
}

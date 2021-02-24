<?php
namespace Lucio\FileProcessor\Model\File;

use Magento\MediaStorage\Model\File\Validator\NotProtectedExtension;

class Uploader extends \Magento\Framework\File\Uploader
{
    protected $fileId = 'origin_file';
    protected $_enableFilesDispersion = true;
    protected $_allowRenameFiles = true;
    protected $_allowedExtensions = ['cvs', 'other'];
    protected $_validator;

    public function __construct(NotProtectedExtension $validator)
    {
        $this->_validator = $validator;
        parent::__construct($this->fileId);
    }

    public function checkAllowedExtension($extension)
    {
        //validate with protected file types
        if (!$this->_validator->isValid($extension)) {
            return false;
        }

        return parent::checkAllowedExtension($extension);
    }
}

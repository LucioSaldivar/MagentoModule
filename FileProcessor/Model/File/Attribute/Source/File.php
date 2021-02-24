<?php
namespace Lucio\FileProcessor\Model\File\Attribute\Source;

class File implements \Magento\Framework\Option\ArrayInterface
{
    public function toOptionArray()
    {
        $options = [
            0 => [
                'label' => 'Please select',
                'value' => 0
            ],
            1 => [
                'label' => 'CSV',
                'value' => 1
            ],
            2  => [
                'label' => 'Other',
                'value' => 2
            ],
        ];

        return $options;
    }
}

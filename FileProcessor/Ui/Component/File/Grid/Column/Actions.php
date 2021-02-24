<?php
namespace Lucio\FileProcessor\Ui\Component\File\Grid\Column;

use Lucio\FileProcessor\Api\Data\FileInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;

class Actions extends Column
{
    protected $urlBuilder;

    public function __construct(
        UrlInterface $urlBuilder,
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }
    public function prepareDataSource(array $dataSource)
    {
        if( isset($dataSource['data']['items']) ) {
            foreach( $dataSource['data']['items'] as &$item ) {
                if( isset($item['entity_id']) ) {
                        $item[$this->getData('name')]['restart'] = [
                            'href' => $this->urlBuilder->getUrl(
                                'lucio_fileprocessor/file/restart',
                                ['entity_id' => $item['entity_id']]
                            ),
                            'label' => __('Restart'),
                            'confirm' => [
                                'title' => __('Restart %1', $item['key']),
                                'message' => __('Are you sure you want to restart %1?', $item['key'])
                            ],
                            'hidden' => false
                        ];
                }
            }
        }

        return $dataSource;
    }
}

<?php

namespace Born\WordpressBlog\Model\Page\Source;

use Magento\Framework\Data\OptionSourceInterface;
//use Magento\Cms\Model\ResourceModel\Page\CollectionFactory;
use Born\WordpressBlog\Model\ResourceModel\Post\CollectionFactory;

class CmsLayout implements OptionSourceInterface
{
    public function __construct(CollectionFactory $CollectionFactory)
    {
        $this->CollectionFactory = $CollectionFactory;
    }

    public function toOptionArray()
    {
        $collections = $this->CollectionFactory->create();
        $options = [];
        foreach ($collections as $item) {
            $options[] = [
                'label' => $item->getId(),
                'value' => $item->getId(),
            ];
        }
        $this->options = $options;

        return $options;
    }
}

<?php

namespace Born\WordpressBlog\Block;

class RenderAllCategories extends \Magento\Framework\View\Element\Template
{

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Born\WordpressBlog\Model\ResourceModel\Category\CollectionFactory $collectionFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->collectionFactory = $collectionFactory;
    }

    public function getpagename()
    {
        $collection = $this->collectionFactory->create();
        return $collection;
    }

}
<?php

namespace Born\WordpressBlog\Block;

class RenderAllPosts extends \Magento\Framework\View\Element\Template
{

    public function __construct(
        \Magento\Framework\App\Request\Http $request,
        \Magento\Framework\View\Element\Template\Context $context,
        \Born\WordpressBlog\Model\ResourceModel\Post\CollectionFactory $collectionFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->request = $request;
        $this->collectionFactory = $collectionFactory;
    }

    public function getpagetitle()
    {   
        $id = $this->request->getParam('id');
        $collection = $this->collectionFactory->create();
        $collection->addFieldToSelect('*');
        $collection->addFieldToFilter('category_id',array('eq'=>$id));
        return $collection;
    }
}
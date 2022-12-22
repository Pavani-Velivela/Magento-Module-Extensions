<?php

namespace Born\WordpressBlog\Controller\Adminhtml\Categories;

class Category extends \Magento\Backend\App\Action

{

    const ADMIN_RESOURCE = 'Born_WordpressBlog::categories';

	protected $resultPageFactory = false;

	public function __construct(
		\Magento\Backend\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $resultPageFactory
		)
	{
		parent::__construct($context);
		$this->resultPageFactory = $resultPageFactory;
	}

	public function execute()
	{
		$resultPage = $this->resultPageFactory->create();
		$resultPage->getConfig()->getTitle()->prepend((__('items')));
		$resultPage->setActiveMenu('Born_WordpressBlog::categories');
    	return $resultPage;
	}
}
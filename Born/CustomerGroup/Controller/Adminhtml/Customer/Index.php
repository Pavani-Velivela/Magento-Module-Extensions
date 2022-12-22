<?php

namespace Born\CustomerGroup\Controller\Adminhtml\Customer;

class Index extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'Born_Born::born';

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
		$resultPage->setActiveMenu('Born_CustomerGroup::customers');
		$resultPage->getConfig()->getTitle()->prepend(__('Customers'));
		return $resultPage;
	}
}
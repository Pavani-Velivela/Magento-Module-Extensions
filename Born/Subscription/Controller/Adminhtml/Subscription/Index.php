<?php

namespace Born\Subscription\Controller\Adminhtml\Subscription;

class Index extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'Born_Subscription::subscription';

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
		$resultPage->getConfig()->getTitle()->prepend((__('Subscription')));
		$resultPage->setActiveMenu('Born_Subscription::Subscription');

		return $resultPage;
	}
}
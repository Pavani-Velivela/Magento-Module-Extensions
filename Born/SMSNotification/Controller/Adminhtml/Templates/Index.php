<?php

namespace Born\SMSNotification\Controller\Adminhtml\Templates;

class Index extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'Born_SMSNotification::smstemplate';

	protected $resultPageFactory = false ;
               
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
		$resultPage->getConfig()->getTitle()->prepend((__('SMS Template')));
		$resultPage->setActiveMenu('Born_SMSNotification::smstemplate');

		return $resultPage;
                                    
	}
}
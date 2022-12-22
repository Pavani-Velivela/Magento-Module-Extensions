<?php

namespace Born\GeoIp\Controller\Adminhtml\Currency;

class Index extends \Magento\Backend\App\Action
{
    //const ADMIN_RESOURCE = 'Born_GeoIp::currencymapping';

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
		$resultPage->getConfig()->getTitle()->prepend((__('Currency Mapping')));
		//$resultPage->setActiveMenu('Born_GeoIp::currencymapping');

		return $resultPage;
                                    
	}
}
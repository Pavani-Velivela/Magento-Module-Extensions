<?php

namespace Born\GeoIp\Controller\Adminhtml\Country;

class Index extends \Magento\Backend\App\Action
{
    //const ADMIN_RESOURCE = 'Born_GeoIp::countrymapping';

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
		$resultPage->getConfig()->getTitle()->prepend((__('Country Mapping')));
		//$resultPage->setActiveMenu('Born_GeoIp::countrymapping');

		return $resultPage;
                                    
	}
}
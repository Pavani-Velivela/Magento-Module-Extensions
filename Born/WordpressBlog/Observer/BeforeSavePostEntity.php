<?php

namespace Born\WordpressBlog\Observer;

use Magento\Framework\Event\ObserverInterface;

class SavePostEntity implements ObserverInterface
{
	public function execute(\Magento\Framework\Event\Observer $observer)
	{   
        $object = $observer->getData('data_object');
        $post = $object->getData();
		
		$writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test.log');
		$logger = new \Zend\Log\Logger();
		$logger->addWriter($writer);
	
		$logger ->info(print_r($post, true));
	}
}
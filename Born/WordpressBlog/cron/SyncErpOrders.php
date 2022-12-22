<?php

namespace Born\WordpressBlog\Cron;

class SyncErpOrders
{
	public function execute()
	{
		$writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test.log');
		$logger = new \Zend\Log\Logger();
		$logger->addWriter($writer);
		$logger->info('Born Cron called at: '.date('Y-m-d H:i:s'));
	}
}
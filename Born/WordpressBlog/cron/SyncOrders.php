<?php

namespace Born\WordpressBlog\Cron;

class SyncOrders
{
    public function callthis()
    {


        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);

        $logger->info('techm cron jobs called');
    }
}

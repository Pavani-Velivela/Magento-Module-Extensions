<?php
namespace Born\CronScheduler\Model\ResourceModel\Schedule;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	protected $_idFieldName = 'schedule_id';
	protected $_eventPrefix = 'cronscheduler_schedule_collection';
	protected $_eventObject = 'schedule_collection';

	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('Born\CronScheduler\Model\Schedule', 'Born\CronScheduler\Model\ResourceModel\Schedule');
	}

}
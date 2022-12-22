<?php
namespace Born\CronScheduler\Model\ResourceModel\Job;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	protected $_idFieldName = 'schedule_id';
	protected $_eventPrefix = 'cronscheduler_schedule_job_collection';
	protected $_eventObject = 'schedule_job_collection';

	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('Born\CronScheduler\Model\Job', 'Born\CronScheduler\Model\ResourceModel\Job');
	}

}
<?php
namespace Born\CronScheduler\Model;
class Job extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
	const CACHE_TAG = 'cronscheduler_schedule_job';

	protected $_cacheTag = 'cronscheduler_schedule_job';

	protected $_eventPrefix = 'cronscheduler_schedule_job';

	protected function _construct()
	{
		$this->_init('Born\CronScheduler\Model\ResourceModel\Job');
	}

	public function getIdentities()
	{
		return [self::CACHE_TAG . '_' . $this->getId()];
	}

	public function getDefaultValues()
	{
		$values = [];

		return $values;
	}
}
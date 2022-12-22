<?php
namespace Born\CronScheduler\Model;
class Schedule extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
	const CACHE_TAG = 'cronscheduler_schedule';

	protected $_cacheTag = 'cronscheduler_schedule';

	protected $_eventPrefix = 'cronscheduler_schedule';

	protected function _construct()
	{
		$this->_init('Born\CronScheduler\Model\ResourceModel\Schedule');
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
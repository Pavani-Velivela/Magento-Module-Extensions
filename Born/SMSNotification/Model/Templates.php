<?php

namespace Born\SMSNotification\Model;
class Templates extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
	const CACHE_TAG = 'sms_template';

	protected $_cacheTag = 'sms_template';

	protected $_eventPrefix = 'sms_template';

	protected function _construct()
	{
		$this->_init('\Born\SMSNotification\Model\ResourceModel\Templates');
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
<?php

namespace Born\GeoIp\Model;
class Currency extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
	const CACHE_TAG = 'currencymapping';

	protected $_cacheTag = 'currencymapping';

	protected $_eventPrefix = 'currencymapping';

	protected function _construct()
	{
		$this->_init('\Born\GeoIp\Model\ResourceModel\Currency');
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
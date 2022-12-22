<?php

namespace Born\GeoIp\Model;
class Country extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
	const CACHE_TAG = 'countrymapping';

	protected $_cacheTag = 'countrymapping';

	protected $_eventPrefix = 'countrymapping';

	protected function _construct()
	{
		$this->_init('\Born\GeoIp\Model\ResourceModel\Country');
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
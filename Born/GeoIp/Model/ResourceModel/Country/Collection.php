<?php

namespace Born\GeoIp\Model\ResourceModel\Country;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	protected $_idFieldName = 'id';
	protected $_eventPrefix = 'geoip_country_collection';
	protected $_eventObject = 'country_collection';

	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init(
                       \Born\GeoIp\Model\Country::class,
			\Born\GeoIp\Model\ResourceModel\Country::class
                                                   );
	}
}
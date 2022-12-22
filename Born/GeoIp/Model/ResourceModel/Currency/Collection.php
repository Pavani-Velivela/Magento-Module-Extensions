<?php

namespace Born\GeoIp\Model\ResourceModel\Currency;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	protected $_idFieldName = 'id';
	protected $_eventPrefix = 'currency_collection';
	protected $_eventObject = 'currency_collection';

	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init(
                         \Born\GeoIp\Model\currency::class,
			\Born\GeoIp\Model\ResourceModel\Currency::class
                                                   );
	}
}
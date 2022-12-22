<?php

namespace Born\SMSNotification\Model\ResourceModel\Templates;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	protected $_idFieldName = 'id';
	protected $_eventPrefix = 'sms_template_collection';
	protected $_eventObject = 'templates_collection';

	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init(
                                                     \Born\SMSNotification\Model\Templates::class,
			\Born\SMSNotification\Model\ResourceModel\Templates::class
                                                   );
	}
}
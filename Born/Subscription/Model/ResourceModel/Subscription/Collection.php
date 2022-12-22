<?php
namespace Born\Subscription\Model\ResourceModel\Subscription;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	protected $_idFieldName = 'id';
	protected $_eventPrefix = 'Born_Subscription_collection';
	protected $_eventObject = 'Born_Subscription_collection';

	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('Born\Subscription\Model\Subscription', 'Born\Subscription\Model\ResourceModel\Subscription');
	}

}
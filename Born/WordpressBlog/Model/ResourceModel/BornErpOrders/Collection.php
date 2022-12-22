<?php
namespace Born\WordpressBlog\Model\ResourceModel\BornErpOrders;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	protected $_idFieldName = 'id';
	protected $_eventPrefix = 'born_wordpress_BornErpOrders_collection';
	protected $_eventObject = 'BornErpOrders_collection';

	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('Born\WordpressBlog\Model\BornErpOrders', 'Born\WordpressBlog\Model\ResourceModel\BornErpOrders');
	}

}

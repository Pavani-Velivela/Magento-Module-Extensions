<?php
namespace Born\WordpressBlog\Model\ResourceModel\Category;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	protected $_idFieldName = 'id';
	protected $_eventPrefix = 'born_wordpressblog_category_collection';
	protected $_eventObject = 'category_collection';

	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('Born\WordpressBlog\Model\Category', 'Born\WordpressBlog\Model\ResourceModel\Category');
	}

}

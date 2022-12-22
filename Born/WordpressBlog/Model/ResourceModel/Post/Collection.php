<?php
namespace Born\WordpressBlog\Model\ResourceModel\Post;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	protected $_idFieldName = 'id';
	protected $_eventPrefix = 'born_wordpressblog_post_collection';
	protected $_eventObject = 'post_collection';

	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('Born\WordpressBlog\Model\Post', 'Born\WordpressBlog\Model\ResourceModel\Post');
	}

}

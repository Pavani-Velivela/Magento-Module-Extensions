<?php
namespace Born\WordpressBlog\Model;
class Post extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
	const CACHE_TAG = 'born_wordpressblog_post';

	protected $_cacheTag = 'born_wordpressblog_post';

	protected $_eventPrefix = 'born_wordpessblog_post';

	protected function _construct()
	{
		$this->_init('Born\WordpressBlog\Model\ResourceModel\Post');
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
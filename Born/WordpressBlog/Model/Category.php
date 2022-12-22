<?php
namespace Born\WordpressBlog\Model;
class Category extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
	const CACHE_TAG = 'born_wordpressblog_category';

	protected $_cacheTag = 'born_wordpressblog_category';

	protected $_eventPrefix = 'born_wordpressblog_category';

	protected function _construct()
	{
		$this->_init('Born\WordpressBlog\Model\ResourceModel\Category');
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
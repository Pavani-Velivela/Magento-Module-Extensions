<?php
namespace Born\WordpressBlog\Model;
class BornErpOrders extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
	const CACHE_TAG = 'born_wordpessblog_BornErpOrders';

	protected $_cacheTag = 'born_wordpessblog_BornErpOrders';

	protected $_eventPrefix = 'born_wordpessblog_BornErpOrders';

	protected function _construct()
	{
		$this->_init('Born\WordpressBlog\Model\ResourceModel\BornErpOrders');
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
<?php
namespace Born\Subscription\Model;
class Subscription extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
	const CACHE_TAG = 'Born_Subscription';

	protected $_cacheTag = 'Born_Subscription';

	protected $_eventPrefix = 'Born_Subscription';

	protected function _construct()
	{
		$this->_init('Born\Subscription\Model\ResourceModel\Subscription');
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
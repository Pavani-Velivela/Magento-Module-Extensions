<?php
namespace Born\WordpressBlog\Model\ResourceModel;


class  BornErpOrders extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
	
	public function __construct(
		\Magento\Framework\Model\ResourceModel\Db\Context $context
	)
	{
		parent::__construct($context);
	}
	
	protected function _construct()
	{
		$this->_init('born_erp_orders', 'id');
	}
	
}
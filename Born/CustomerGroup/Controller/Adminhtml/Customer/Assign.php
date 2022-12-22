<?php
namespace Born\CustomerGroup\Controller\Adminhtml\Customer;

use Magento\Framework\Controller\ResultFactory;

class Assign extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'Born_Born::born';

    private $groups = [];

	public function __construct(
		\Magento\Backend\App\Action\Context $context,
		\Born\CustomerGroup\Model\ResourceModel\Customer\CollectionFactory $collectionFactory,
		\Magento\Customer\Model\ResourceModel\Group\CollectionFactory $groupCollectionFactory
		)
	{
		parent::__construct($context);
		$this->collectionFactory = $collectionFactory;
		$this->groupCollectionFactory = $groupCollectionFactory;
	}

	public function execute()
	{
		$collection = $this->collectionFactory->create();

		/*$orderTable = $collection->getTable('sales_order');
		$collection->getSelect()->joinLeft(
            ['sales_order' => $orderTable],
            'main_table.entity_id = sales_order.customer_id',
            [
                'SUM(sales_order.grand_total) AS born_last_month_purchase'
            ]
        );

        $collection->getSelect()->group('sales_order.customer_id');*/

		
		foreach ($collection as $item) {
		
			$suggestedGroupId = $item->getData('born_suggested_group_id');

			$item->setData('group_id', $suggestedGroupId);
			$item->save();
		}

		$this->messageManager->addSuccessMessage(
            __('Assigned Group Successfully')
        );
        
		$resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
	}

	/* public function getReleventGroupId($amount)
	{
		if (empty($this->groups)) {
			$collection = $this->groupCollectionFactory->create();
			foreach ($collection as $item) {
				// becoz we cannot consider not logged in group id,
				// it is hardcoded label
				// id for not logged in group is 0
				if ($groupId = $item->getData('customer_group_id')) {
					$this->groups[] = $item->getData();
				}
			}
		}

		foreach ($this->groups as $group) {
			$minPrice = (int) $group['min_price'];
			$maxPrice = (int) $group['max_price'];

			if ($amount >= $minPrice && $amount <= $maxPrice) {
				return $group['customer_group_id'];
			}
		}

		return null;
	}*/

}







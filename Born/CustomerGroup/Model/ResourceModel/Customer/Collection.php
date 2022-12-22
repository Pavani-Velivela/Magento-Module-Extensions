<?php

namespace Born\CustomerGroup\Model\ResourceModel\Customer;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'entity_id';

    /**
     * Event prefix
     *
     * @var string
     */
    protected $_eventPrefix = 'born_customer_collection';

    /**
     * Event object
     *
     * @var string
     */
    protected $_eventObject = 'born_customer_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \Born\CustomerGroup\Model\Customer::class,
            \Born\CustomerGroup\Model\ResourceModel\Customer::class
        );
    }
}

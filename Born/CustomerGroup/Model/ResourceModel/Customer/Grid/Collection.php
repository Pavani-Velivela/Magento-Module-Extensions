<?php

namespace Born\CustomerGroup\Model\ResourceModel\Customer\Grid;

use Magento\Framework\Api\Search\SearchResultInterface;
use Magento\Framework\Api\Search\AggregationInterface;
use Born\CustomerGroup\Model\ResourceModel\Customer\Collection as CustomerCollection;

/**
 * Class Collection
 * Collection for displaying grid of sales documents
 */
class Collection extends CustomerCollection implements SearchResultInterface
{
    /**
     * @var AggregationInterface
     */
    protected $aggregations;

    /**
     * @param \Magento\Framework\Data\Collection\EntityFactoryInterface $entityFactory
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy
     * @param \Magento\Framework\Event\ManagerInterface $eventManager
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\EntityManager\MetadataPool $metadataPool
     * @param mixed|null $mainTable
     * @param string $eventPrefix
     * @param mixed $eventObject
     * @param mixed $resourceModel
     * @param string $model
     * @param null $connection
     * @param \Magento\Framework\Model\ResourceModel\Db\AbstractDb|null $resource
     *
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        \Magento\Framework\Data\Collection\EntityFactoryInterface $entityFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        $mainTable,
        $eventPrefix,
        $eventObject,
        $resourceModel,
        $model = \Magento\Framework\View\Element\UiComponent\DataProvider\Document::class,
        $connection = null,
        \Magento\Framework\Model\ResourceModel\Db\AbstractDb $resource = null
    ) {
        parent::__construct(
            $entityFactory,
            $logger,
            $fetchStrategy,
            $eventManager,
            $connection,
            $resource
        );
        $this->_eventPrefix = $eventPrefix;
        $this->_eventObject = $eventObject;
        $this->_init($model, $resourceModel);
        $this->setMainTable($mainTable);
    }

    /**
     * @return AggregationInterface
     */
    public function getAggregations()
    {
        return $this->aggregations;
    }

    /**
     * @param AggregationInterface $aggregations
     * @return $this
     */
    public function setAggregations($aggregations)
    {
        $this->aggregations = $aggregations;
        return $this;
    }

    /**
     * Get search criteria.
     *
     * @return \Magento\Framework\Api\SearchCriteriaInterface|null
     */
    public function getSearchCriteria()
    {
        return null;
    }

    /**
     * Set search criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function setSearchCriteria(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria = null)
    {
        return $this;
    }

    /**
     * Get total count.
     *
     * @return int
     */
    public function getTotalCount()
    {
        return $this->getSize();
    }

    /**
     * Set total count.
     *
     * @param int $totalCount
     * @return $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function setTotalCount($totalCount)
    {
        return $this;
    }

    /**
     * Set items list.
     *
     * @param \Magento\Framework\Api\ExtensibleDataInterface[] $items
     * @return $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function setItems(array $items = null)
    {
        return $this;
    }

    protected function _initSelect()
    {
        $this->addFilterToMap('current_customer_group_code', 'current_customer_group.current_customer_group_code');
        $this->addFilterToMap('suggested_customer_group_code', 'suggested_customer_group.suggested_customer_group_code');
        // $this->addFilterToMap('created_at', 'main_table.created_at');
        // $this->addFilterToMap('updated_at', 'main_table.updated_at');
        // $this->addFilterToMap(
        //     'fullname',
        //     new \Zend_Db_Expr("CONCAT(customer_entity.firstname, ' ', customer_entity.lastname)")
        // );
        
        parent::_initSelect();

        $groupTable = $this->getTable('customer_group');
        
        $this->getSelect()->joinLeft(
            ['current_customer_group' => $groupTable],
            'main_table.group_id = current_customer_group.customer_group_id',
            [
                'current_customer_group.customer_group_code AS current_customer_group_code'
            ]
        );

        $this->getSelect()->joinLeft(
            ['suggested_customer_group' => $groupTable],
            'main_table.born_suggested_group_id = suggested_customer_group.customer_group_id',
            [
                'suggested_customer_group.customer_group_code AS suggested_customer_group_code'
            ]
        );
    }
}

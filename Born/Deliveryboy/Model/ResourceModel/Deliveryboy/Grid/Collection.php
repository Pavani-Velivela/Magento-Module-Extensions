<?php

namespace Born\Deliveryboy\Model\ResourceModel\Deliveryboy\Grid;

use Magento\Framework\Data\Collection\Db\FetchStrategyInterface as FetchStrategy;
use Magento\Framework\Data\Collection\EntityFactoryInterface as EntityFactory;
use Magento\Framework\Event\ManagerInterface as EventManager;
use Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult;
use Psr\Log\LoggerInterface as Logger;

/**
 * Class Collection
 * @package Wagento\Subscription\Model\ResourceModel\Grid
 */
class Collection extends \Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult implements \Magento\Framework\Api\Search\SearchResultInterface
{
    protected $authSession;
    /**
     * Initialize dependencies.
     *
     * @param EntityFactory $entityFactory
     * @param Logger $logger
     * @param FetchStrategy $fetchStrategy
     * @param EventManager $eventManager
     * @param string $mainTable
     * @param string $resourceModel
     */
    public function __construct(
        EntityFactory $entityFactory,
        Logger $logger,
        FetchStrategy $fetchStrategy,
        EventManager $eventManager,
        \Magento\Backend\Model\Auth\Session $authSession, 
        $mainTable = 'sales_order_grid',
        $resourceModel = \Magento\Sales\Model\ResourceModel\Order::class
    ) {
        $this->authSession = $authSession;
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $mainTable, $resourceModel);
    }
     protected function _initSelect()
{
    parent::_initSelect();
    /** admin user filter start **/
    $adminUser = $this->authSession->getUser();
    if ($adminUser->getId()) {
        $adminUserName = $adminUser->getUsername();
        if($adminUserName != "magento")
        $this->addFieldToFilter('delivery_boy', ['eq' => $adminUserName]);
    }
    /** end **/
    $tableDescription = $this->getConnection()->describeTable($this->getMainTable());
    foreach ($tableDescription as $columnInfo) {
      $this->addFilterToMap($columnInfo['COLUMN_NAME'], 'main_table.' . $columnInfo['COLUMN_NAME']);
    }

    return $this;
}
}

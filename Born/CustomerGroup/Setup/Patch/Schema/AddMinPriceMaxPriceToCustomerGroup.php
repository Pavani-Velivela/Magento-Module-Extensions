<?php

namespace Born\CustomerGroup\Setup\Patch\Schema;

use Magento\Framework\Setup\Patch\SchemaPatchInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;
use Magento\Framework\DB\Ddl\Table;

class AddMinPriceMaxPriceToCustomerGroup implements
    SchemaPatchInterface,
    PatchRevertableInterface
{
    public function __construct(
        \Magento\Framework\Setup\ModuleDataSetupInterface $moduleDataSetup
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
    }

    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();
        $this->addMinPriceMaxPriceToCustomerGroupTable();
        $this->moduleDataSetup->getConnection()->endSetup();
    }

    public static function getDependencies()
    {
        return [];
    }

    public function revert()
    {
        $this->moduleDataSetup->getConnection()->startSetup();
        $this->moduleDataSetup->getConnection()->endSetup();
    }

    public function getAliases()
    {
        return [];
    }

    private function addMinPriceMaxPriceToCustomerGroupTable()
    {
        $this->moduleDataSetup->getConnection()->addColumn(
            $this->moduleDataSetup->getTable('customer_group'),
            'min_price',
            [
                'type' => Table::TYPE_INTEGER,
                'length' => 10,
                'nullable' => true,
                'comment'  => 'Min Price',
            ]
        );

        $this->moduleDataSetup->getConnection()->addColumn(
            $this->moduleDataSetup->getTable('customer_group'),
            'max_price',
            [
                'type' => Table::TYPE_INTEGER,
                'length' => 10,
                'nullable' => true,
                'comment'  => 'Max Price',
            ]
        );
    }
}

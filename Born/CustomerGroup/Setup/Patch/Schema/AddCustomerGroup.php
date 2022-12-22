<?php

namespace Born\CustomerGroup\Setup\Patch\Schema;

use Magento\Framework\Setup\Patch\SchemaPatchInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;
use Magento\Framework\DB\Ddl\Table;

class AddCustomerGroup implements
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
        $this->addCustomerGroupField();
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

    private function addCustomerGroupField()
    {
        $this->moduleDataSetup->getConnection()->addColumn(
            $this->moduleDataSetup->getTable('customer_entity'),
            'born_last_month_purchase',
            [
                'type' => Table::TYPE_DECIMAL,
                'length' => '7,2',
                'nullable' => true,
                'comment'  => 'Last month purchase amount',
            ]
        );

        $this->moduleDataSetup->getConnection()->addColumn(
            $this->moduleDataSetup->getTable('customer_entity'),
            'born_suggested_group_id',
            [
                'type' => Table::TYPE_INTEGER,
                'length' => 11,
                'nullable' => true,
                'comment'  => 'Born Suggested Group ID',
            ]
        );
    }
}

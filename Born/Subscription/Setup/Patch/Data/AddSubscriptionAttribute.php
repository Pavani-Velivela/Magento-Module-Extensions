<?php


namespace Born\Subscription\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Setup\Patch\PatchVersionInterface;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;

class AddSubscriptionAttribute implements DataPatchInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;



    public function __construct(
       \Magento\Framework\Setup\ModuleDataSetupInterface $moduleDataSetup,EavSetupFactory $eavSetupFactory

     ) {

        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetupFactory = $eavSetupFactory;

    }

    public function apply()
     {
        /** @var EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);

        $eavSetup->addAttribute('catalog_product', 'subscription', [
            'type' => 'int',
            'label' => 'Support Subscription',
            'input' => 'select',
            'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
            'default' => 1,
            'global' => ScopedAttributeInterface::SCOPE_STORE,
            'visible' => true,
            'used_in_product_listing' => true,
            'is_used_in_grid' => true,
            'is_visible_in_grid' => true,
            'visible_in_product_listing' => true,
            'user_defined' => true,
            'required' => false,
            'group' => 'General',
            'sort_order' => 90,
            'backend' => '',
            'frontend' => ''
        ]);
    }


     public static function getVersion()
    {
        return '2.0.0';
    }

     public static function getDependencies()
    {
        return [];
    }

    public function getAliases()
    {
        return [];
    }

} 
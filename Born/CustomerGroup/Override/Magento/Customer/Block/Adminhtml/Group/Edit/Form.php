<?php

namespace Born\CustomerGroup\Override\Magento\Customer\Block\Adminhtml\Group\Edit;

use Magento\Customer\Controller\RegistryConstants;

class Form extends \Magento\Customer\Block\Adminhtml\Group\Edit\Form
{
	public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Tax\Model\TaxClass\Source\Customer $taxCustomer,
        \Magento\Tax\Helper\Data $taxHelper,
        \Magento\Customer\Api\GroupRepositoryInterface $groupRepository,
        \Magento\Customer\Api\Data\GroupInterfaceFactory $groupDataFactory,
        \Magento\Customer\Model\GroupFactory $groupFactory,
        array $data = []
    ) {
        parent::__construct($context, $registry, $formFactory, $taxCustomer, $taxHelper, $groupRepository, $groupDataFactory, $data);
        $this->groupFactory = $groupFactory;
    }

	protected function _prepareLayout()
    {
        parent::_prepareLayout();

        $form = $this->getForm();

        $fieldset = $form->addFieldset('born_price_fieldset', ['legend' => __('Born Price Range Configuration')]);

        $fieldset->addField(
            'min_price',
            'text',
            [
                'name' => 'min_price',
                'label' => __('Min Price'),
                'title' => __('Min Price'),
                'class' => 'required validate-number',
                'required' => true
            ]
        );

        $fieldset->addField(
            'max_price',
            'text',
            [
                'name' => 'max_price',
                'label' => __('Max Price'),
                'title' => __('Max Price'),
                'class' => 'required validate-number',
                'required' => true
            ]
        );

        $groupId = $this->_coreRegistry->registry(RegistryConstants::CURRENT_GROUP_ID);
        if ($groupId !== null) {
        	$customerGroup = $this->groupFactory->create()->load($groupId);
        	$form->addValues(
                [
                    'min_price' => $customerGroup->getMinPrice(),
                    'max_price' => $customerGroup->getMaxPrice()
                ]
            );
        }
    }
}
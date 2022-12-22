<?php
    namespace Born\SMSNotification\Block\Adminhtml\Templates\Edit\Buttons;

    class Form extends \Magento\Backend\Block\Widget\Form\Generic
    {
        /**
         * @var \Magento\Store\Model\System\Store
         */
        protected $_systemStore;
        
        /**
         * Core registry
         *
         * @var \Magento\Framework\Registry
         */
        protected $_coreRegistry;

        /**
         * @param \Magento\Backend\Block\Template\Context $context
         * @param \Magento\Framework\Registry $registry
         * @param \Magento\Framework\Data\FormFactory $formFactory
         * @param \Magento\Store\Model\System\Store $systemStore
         * @param array $data
         */
        public function __construct(
            \Magento\Backend\Block\Template\Context $context,
            \Magento\Framework\Registry $registry,
            \Magento\Framework\Data\FormFactory $formFactory,
            \Magento\Store\Model\System\Store $systemStore,
            array $data = []
        ) {
            $this->_systemStore = $systemStore;
            $this->_coreRegistry = $registry;
            parent::__construct($context, $registry, $formFactory, $data);
        }

        /**
         * Init form
         *
         * @return void
         */
        protected function _construct()
        {
            parent::_construct();
            $this->setId('customfield_form');
            $this->setTitle(__('Fields Information'));
        }

        /**
         * Prepare form
         *
         * @return $this
         */
        protected function _prepareForm()
        {

            $form = $this->_formFactory->create(
                ['data' => ['id' => 'edit_form', 'enctype' => 'multipart/form-data', 'action' => $this->getData('action'), 'method' => 'post']]
            );
            $form->setHtmlIdPrefix('customfields_');

            $fieldset = $form->addFieldset(
                'base_fieldset',
                ['legend' => __('Field Information'), 'class' => 'fieldset-wide']
            );

             $fieldset->addField(
                'store',
                'multiselect',
                [
                    'name' => 'store[]',
                    'label' => __('Store View'),
                    'title' => __('Store View'),
                    'required' => true,
                    'values' => $this->_systemStore->getStoreValuesForForm(false, true)
                ]
            );
            
            $form->setUseContainer(true);
            $this->setForm($form);
            return parent::_prepareForm();
        }

    }
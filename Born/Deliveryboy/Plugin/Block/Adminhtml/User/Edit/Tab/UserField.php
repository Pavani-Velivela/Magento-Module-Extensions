<?php 
namespace Born\Deliveryboy\Plugin\Block\Adminhtml\User\Edit\Tab;

class UserField
{
    public function aroundGetFormHtml(
        \Magento\User\Block\User\Edit\Tab\Main $subject,
        \Closure $proceed)
    {
        $form = $subject->getForm();
        if (is_object($form))
        {
             $fieldset = $form->addFieldset('admin_user_image', ['legend' => __('Custom Field')]);
            $fieldset->addField(
                'user_image',
                'image',
                [
                    'name' => 'user_image',
                    'label' => __('Image'),
                    'id' => 'user_image',
                    'title' => __('Image'),
                    'required' => false,
                    'note' => 'Allow image type: jpg, jpeg, png'
                ]
            );

            $subject->setForm($form);
        }

        return $proceed();
    }
}
<?php
/**
 * Created By : Rohan Hapani
 */
namespace Born\Subscription\Plugin;

class HideBtn
{               
    public function afterIsSaleable(\Magento\Catalog\Model\Product $product)
    {
        if($product->getId() == 1)
        {
            return false; // For hide button
        } else {
            return true; // For display button
        }
    }
}
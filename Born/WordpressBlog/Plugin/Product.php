<?php

namespace Born\WordpressBlog\Plugin;

class Product
{
     public function afterGetName($subject, $result) //after plugin
     {
       return $result . '';
    //     //  return  '';
        
       
    }
    // public function afterGetPrice(\Magento\Catalog\Model\Product $subject, $result) 
    // {

        // $result=$subject->getPrice();
        // if($result<=60)
        //    {
        //        return $result=$result+10;
        //    }
        //   return $result;
     
       //return $result+2;
    //}

}

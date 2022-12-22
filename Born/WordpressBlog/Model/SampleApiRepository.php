<?php

namespace Born\WordpressBlog\Model;

use Born\WordpressBlog\Api\SampleApiInterface;

class  SampleApiRepository implements SampleApiInterface
{

    
    public function sayHello($name)
    {

      
        return "hello , " . $name . " how r u";
    }
}

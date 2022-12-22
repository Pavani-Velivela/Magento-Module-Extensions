<?php

namespace Born\GeoIp\Plugin;

use \Magento\Framework\Controller\ResultFactory;
use \Magento\Framework\UrlInterface;
use \Magento\Framework\App\FrontControllerInterface;
use \Magento\Framework\App\RequestInterface;

class AutoRedirect
{

    protected $logger;

    protected $remoteAddress;

    protected $_curl;

    protected $_resultFactory;

    public function __construct(
    \Psr\Log\LoggerInterface $logger, 
    \Magento\Framework\HTTP\PhpEnvironment\RemoteAddress $remoteAddress,
    ResultFactory $resultFactory,
    UrlInterface    $urlInterface,
    \Magento\Framework\HTTP\Client\Curl $curl) {
        $this->logger = $logger;
        $this->_curl = $curl;
        $this->remoteAddress = $remoteAddress;
        $this->_resultFactory = $resultFactory;
        $this->urlInterface  = $urlInterface;
    }

   public function aroundDispatch(
        FrontControllerInterface $subject,
        callable $proceed,
        RequestInterface $request
    ) {

        $visitorIp = $this->getVisitorIp();
        $url = "freegeoip.net/json/".$visitorIp;
        $this->_curl->get($url);
        $response = json_decode($this->_curl->getBody(), true);
        //$countryName = $response['country_name'];
        //$stateName = $response['region_name'];

        //if any user browse this url than only they get redirect
        $redirectUrl = 'xyz.com';

        // urls array
        $match_urls = array(
            "http://".$redirectUrl."/",
            "http://www.".$redirectUrl."/",
            "http://".$redirectUrl,
            "http://www.".$redirectUrl,
            "https://".$redirectUrl."/",
            "https://www.".$redirectUrl."/",
            "https://".$redirectUrl,
            "https://www.".$redirectUrl,
            "".$redirectUrl."/",
            "".$redirectUrl
        );

        $url = $this->urlInterface->getCurrentUrl();    


        if(in_array($url, $match_urls)) {
            //set any condition as per your requirement
            if($countryName == "CA"){
                $resultRedirect = $this->_resultFactory->create(ResultFactory::TYPE_REDIRECT);
                $resultRedirect->setHeader('Cache-Control','null');
                $resultRedirect->setUrl('your redirect url here');
                return $resultRedirect;     
            } else {
                $resultRedirect = $this->_resultFactory->create(ResultFactory::TYPE_REDIRECT);
                $resultRedirect->setHeader('Cache-Control','null');
                $resultRedirect->setUrl('your other redirect url here');
                return $resultRedirect;
           }
        } else {
           return $proceed($request);
        }
    }

    function getVisitorIp() {
        return $this->remoteAddress->getRemoteAddress();
    }
}
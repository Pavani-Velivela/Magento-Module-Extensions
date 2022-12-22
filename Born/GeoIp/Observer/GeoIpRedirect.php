<?php 

namespace Born\GeoIp\Observer;

use Magento\Framework\Controller\ResultFactory; 

class GeoIpRedirect implements \Magento\Framework\Event\ObserverInterface
{

    protected $_storeManager;

    protected $_curl;

    protected $_session;

    protected $_objectManager;

    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\HTTP\Client\Curl $curl,
        \Magento\Framework\Session\SessionManagerInterface $session,
        \Magento\Framework\ObjectManagerInterface $objectManager
    ) {
        $this->_storeManager   = $storeManager;
        $this->_curl           = $curl;
        $this->_session        = $session;
        $this->_objectManager  = $objectManager;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $isChangeStore    = $this->_session->getCustomRedirection();
        if(!($isChangeStore)){
            $visitorIp        = $this->getVisitorIp();
            //$visitorIp        = '158.69.121.179';  // for canada
            $baseUrl          = $this->_storeManager->getStore()->getBaseUrl();
            $apiUrl           = "http://www.geoplugin.net/json.gp?ip=".$visitorIp;
            $this->_curl->get($apiUrl);
            $response         = json_decode($this->_curl->getBody(), true);
            $countryCode      = $response['geoplugin_countryCode'];
            if($countryCode != null && $countryCode == 'IN'){
                $redirectionUrl  = $baseUrl."stores/store/redirect/?___store=india&___from_store=usa"; 
                $this->_session->setCustomRedirection(true);  
                $observer->getControllerAction()->getResponse()->setRedirect($redirectionUrl);
            }
        }
    }

    function getVisitorIp()
    {
        $remoteAddress = $this->_objectManager->create('Magento\Framework\HTTP\PhpEnvironment\RemoteAddress');
        return $remoteAddress->getRemoteAddress();
    }

}
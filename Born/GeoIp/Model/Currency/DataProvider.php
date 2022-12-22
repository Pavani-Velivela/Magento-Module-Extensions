<?php
namespace Born\GeoIp\Model\Currency;

use Born\GeoIp\Model\ResourceModel\Currency\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;

/**
 * Class DataProvider
 */
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var \Born\GeoIp\Model\ResourceModel\Currency\Collection
     */
    protected $collection;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $pageCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $currencyCollectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $currencyCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->meta = $this->prepareMeta($this->meta);
    }

    /**
     * Prepares Meta
     *
     * @param array $meta
     * @return array
     */
    public function prepareMeta(array $meta)
    {
        return $meta;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        /** @var $currency \Born\GeoIp\Model\Currency */
        foreach ($items as $currency) {
            $this->loadedData[$currency->getId()] = $currency->getData();
        }

        $data = $this->dataPersistor->get('currencymapping');
        if (!empty($data)) {
            $currency = $this->collection->getNewEmptyItem();
            $currency->setData($data);
            $this->loadedData[$currency->getId()] = $currency->getData();
            $this->dataPersistor->clear('currencymapping');
        }

        return $this->loadedData;
    }
}
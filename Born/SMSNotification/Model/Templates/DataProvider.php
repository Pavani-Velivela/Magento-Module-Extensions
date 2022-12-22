<?php
namespace Born\SMSNotification\Model\Templates;

use Born\SMSNotification\Model\ResourceModel\Templates\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;

/**
 * Class DataProvider
 */
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var \Born\SMSNotification\Model\ResourceModel\Templates\Collection
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
        CollectionFactory $templatesCollectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $templatesCollectionFactory->create();
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
        /** @var $templates \Born\SMSNotification\Model\Templates */
        foreach ($items as $templates) {
            $this->loadedData[$templates->getId()] = $templates->getData();
        }

        $data = $this->dataPersistor->get('sms_template');
        if (!empty($data)) {
            $templates = $this->collection->getNewEmptyItem();
            $templates->setData($data);
            $this->loadedData[$templates->getId()] = $templates->getData();
            $this->dataPersistor->clear('sms_template');
        }

        return $this->loadedData;
    }
}
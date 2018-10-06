<?php

namespace Paul\Vendors\Model\Attribute\Source;
use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

class Vendors extends AbstractSource
{
    /**
    * @var \Paul\Vendors\Model\Vendors
    */
    protected $_model;
    /**
    * Vendor constructor.
    * @param \Paul\Vendors\Model\Vendors $model
    */
    public function __construct(\Paul\Vendors\Model\Vendors $model)
    {
        $this->_model = $model;
    }
    /**
    * Create options array
    *
    * @return array
    */
    public function getAllOptions()
    {
        $options = [];
        $modelCollection = $this->_model->getCollection()
        ->addFieldToSelect('entity_id')
        ->addFieldToSelect('name');
                foreach ($modelCollection as $item){
        $options[] = [
            'label' => $item->getName(),
            'value' => $item->getId(),
        ];
        }
        return $options;
    }
}
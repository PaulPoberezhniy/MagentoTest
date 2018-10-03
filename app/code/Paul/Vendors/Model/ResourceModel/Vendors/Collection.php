<?php
namespace Paul\Vendors\Model\ResourceModel\Vendors;

use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{

    protected $_idFieldName = \Paul\Vendors\Model\Vendors::VENDOR_ID;

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Paul\Vendors\Model\Vendors', 'Paul\Vendors\Model\ResourceModel\Vendors');
    }

}
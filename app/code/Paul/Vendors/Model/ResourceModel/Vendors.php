<?php

namespace Paul\Vendors\Model\ResourceModel;

use \Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Vendors post mysql resource
 */
class Vendors extends AbstractDb
{

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        // Table Name and Primary Key column
        $this->_init('paul_vendors', 'entity_id');
    }

}
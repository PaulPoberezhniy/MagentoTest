<?php

namespace Paul\Vendors\Block\Product\View;

use Magento\Catalog\Block\Product\AbstractProduct;

class Vendors extends AbstractProduct
{
    protected $_vendor;

    /**
     * @param \Magento\Catalog\Block\Product\Context $context
     * @param \Paul\Vendors\Model\Vendors $vendor ,
     * @param array $data
     */
    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Paul\Vendors\Model\Vendors $vendor,
        array $data = []
    )
    {
        $this->_vendor = $vendor;

        parent::__construct(
            $context,
            $data
        );
    }

    protected function _getVendor($entityId)
    {
        $item = $this->_vendor->load($entityId);
        return ($item->getData());
    }

    public function getLoadedVendor($entityId)
    {
        return $this->_getVendor($entityId);
    }
}
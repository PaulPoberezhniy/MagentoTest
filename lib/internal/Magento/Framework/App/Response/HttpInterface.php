<?php
/**
 * HTTP response interface
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Framework\App\Response;

interface HttpInterface extends \Magento\Framework\App\ResponseInterface
{
    /**
     * Set HTTP response code
     *
     * @param int $code
     * @return void
     */
    public function setHttpResponseCode($code);
}

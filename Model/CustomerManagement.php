<?php
/**
 * Landofcoder
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the landofcoder.com license that is
 * available through the world-wide-web at this URL:
 * http://landofcoder.com/license
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category   Landofcoder
 * @package    Lof_POS
 * @copyright  Copyright (c) 2016 Landofcoder (http://www.landofcoder.com/)
 * @license    http://www.landofcoder.com/LICENSE-1.0.html
 */

namespace Lof\Pos\Model;

use Lof\Pos\Api\CustomerRepositoryInterface;
use Magento\Integration\Model\Oauth\TokenFactory;

class CustomerManagement implements CustomerRepositoryInterface
{
    /**
     * @var $tokenModelFactory
     */
    protected $tokenModelFactory;

    /**
     * @param TokenFactory $tokenModelFactory
     */
    public function __construct(TokenFactory $tokenModelFactory)
    {
        $this->tokenModelFactory = $tokenModelFactory;
    }

    /**
     * Get customer token by id.
     * @param int $customer_id
     * @return string
     */
    public function getCustomerToken($customer_id)
    {
        $customerToken = $this->tokenModelFactory->create();
        $tokenKey = $customerToken->createCustomerToken($customer_id)->getToken();
        return $tokenKey;
    }
}

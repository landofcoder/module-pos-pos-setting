<?php
/**
 * Landofcoder
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Landofcoder.com license that is
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

namespace Lof\Pos\Model\Config\Source;

class Customer implements \Magento\Framework\Option\ArrayInterface
{
    protected $_customerFactory;

    public function __construct(\Magento\Customer\Model\CustomerFactory $customerFactory)
    {
        $this->_customerFactory = $customerFactory;
    }

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        $getCustomer = $this->getCustomerCollection();
        $customers[] = [
            'value' => 0,
            'label' => '---Please Select---'
        ];
        $key = 1;

        foreach ($getCustomer as $item) {
            $customers[$key]['value'] = $item['entity_id'];
            $customers[$key]['label'] = $item['email'];
            $key++;
        }
        return $customers;
    }

    public function getCustomerCollection()
    {
        return $this->_customerFactory->create()
            ->getCollection()
            ->getData();
    }
}
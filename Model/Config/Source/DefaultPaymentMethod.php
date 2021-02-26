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

class DefaultPaymentMethod implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @var $scope
     */
    protected $scope;

    /**
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scope
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scope
    )
    {
        $this->scope = $scope;
    }

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        $methodList = $this->scope->getValue('payment');
        $method = [];
        foreach ($methodList as $code => $_method) {
            if (isset($_method['active']) && $_method['active'] == 1) {
                if ($code != 'free' && $code != 'paypal_billing_agreement') {
                    $method[] = ['value' => $code, 'label' => __($_method['title'])];
                }
            }
        }
        return $method;
    }
}

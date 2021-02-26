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

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Shipping\Model\Config;

class DefaultShippingMethod implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @var $scopeConfig
     * @var $shippingModelConfig
     */
    protected $scopeConfig;
    protected $shippingModelConfig;

    /**
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Shipping\Model\Config $shippingModelConfig
     */
    public function __construct(
        Config $shippingModelConfig, ScopeConfigInterface $scopeConfig
    )
    {
        $this->shippingModelConfig = $shippingModelConfig;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        $shippings = $this->shippingModelConfig->getActiveCarriers();
        $methods = [];
        foreach ($shippings as $shippingCode => $shippingModel) {
            if ($carrierMethods = $shippingModel->getAllowedMethods()) {
                foreach ($carrierMethods as $methodCode => $method) {
                    $code = $methodCode;
                    $carrierTitle = $this->scopeConfig->getValue('carriers/' . $shippingCode . '/title');
                    $methods[] = ['value' => $code, 'label' => $carrierTitle];
                }
            }
        }
        return $methods;
    }
}

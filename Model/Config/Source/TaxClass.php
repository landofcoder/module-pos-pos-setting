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

use Magento\Tax\Model\TaxClass\Source\Product as ProductTaxClassSource;

/**
 * @api
 * @since 100.0.2
 */
class TaxClass implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @var ProductTaxClassSource
     */
    protected $productTaxClassSource;

    /**
     * @param ProductTaxClassSource $productTaxClassSource
     */
    public function __construct(
        ProductTaxClassSource $productTaxClassSource
    )
    {
        $this->productTaxClassSource = $productTaxClassSource;
    }

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        $taxClassess = $this->productTaxClassSource->getAllOptions();
        return $taxClassess;
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        $taxClassess = $this->productTaxClassSource->getAllOptions();
        return $taxClassess;
    }
}

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

namespace Lof\Pos\Api;

interface ConfigRepositoryInterface
{
    /**
     * Get System Config.
     * @return mixed
     */
    public function getSystemConfig();

    /**
     * @return mixed
     */
    public function getShopInfo();

    /**
     * @param string $params
     * @return mixed
     */
    public function createQuoteCheckout($params);

    /**
     * Apply discount code
     * @param string $params
     * @return mixed
     */
    public function posApplyDiscountCode($params);

    /**
     * @return mixed
     */
    public function checkAllModuleInstalled();
}

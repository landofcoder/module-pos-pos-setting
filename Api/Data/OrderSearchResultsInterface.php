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

namespace Lof\Pos\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface for pos order search results.
 * @api
 * @since 100.0.2
 */
interface OrderSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get orders list.
     *
     * @return \Lof\Pos\Api\Data\OrderInterface[]
     */
    public function getItems();

    /**
     * Set orders list.
     *
     * @param \Lof\Pos\Api\Data\OrderInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

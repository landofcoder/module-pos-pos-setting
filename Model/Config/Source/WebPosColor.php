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

/**
 * @api
 * @since 100.0.2
 */
class WebPosColor implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 'default', 'label' => __('DEFAULT')],
            ['value' => 'blue', 'label' => __('BLUE')],
            ['value' => 'green', 'label' => __('GREEN')],
            ['value' => 'orange', 'label' => __('ORANGE')],
            ['value' => 'red', 'label' => __('RED')]
        ];
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'default' => __('DEFAULT'),
            'blue' => __('BLUE'),
            'green' => __('GREEN'),
            'orange' => __('ORANGE'),
            'red' => __('RED')
        ];
    }
}

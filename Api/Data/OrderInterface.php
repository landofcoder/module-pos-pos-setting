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

/**
 * Pos order interface.
 * @api
 * @since 100.0.2
 */
interface OrderInterface
{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const POS_ORDER_ID = 'pos_order_id';
    const SALES_ORDER_ID = 'sales_order_id';
    const OUTLET_ID = 'outlet_id';
    const USER_ID = 'user_id';
    const CASHIER_ID = 'cashier_id';
    const CASHIER_NAME = 'cashier_name';
    const CASHIER_PHONE = 'cashier_phone';
    const CASHIER_EMAIL = 'cashier_email';
    const CASHIER_ADDRESS = 'cashier_address';
    const CREATED_AT = 'created_at';
    const GRAND_TOTAL = 'grand_total';
    const ORDER_STATUS = "order_status";

    /**#@-*/

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getOrderId();

    /**
     * Get sales_order_id
     *
     * @return int
     */
    public function getSalesOrderId();

    /**
     * Get outlet_id
     *
     * @return int
     */
    public function getOutletId();

    /**
     * Get user_id
     *
     * @return int
     */
    public function getUserId();

    /**
     * Get cashier_id
     *
     * @return int
     *
     */
    public function getCashierId();

    /**
     * Get cashier_name
     *
     * @return string|null
     */
    public function getCashierName();

    /**
     * Get cashier_phone
     *
     * @return string|null
     */
    public function getCashierPhone();

    /**
     * Get cashier_email
     *
     * @return string|null
     */
    public function getCashierEmail();

    /**
     * Get cashier_address
     *
     * @return string|null
     */
    public function getCashierAddress();

    /**
     * Get created_at
     *
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * Get grand_total
     *
     * @return int|null
     */
    public function getGrandTotal();


    /**
     * Set ID
     *
     * @param int $id
     * @return \Lof\Pos\Api\Data\OrderInterface
     */
    public function setOrderId($id);

    /**
     * Set sales_order_id
     *
     * @param int $sales_order_id
     * @return \Lof\Pos\Api\Data\OrderInterface
     */
    public function setSalesOrderId($sales_order_id);

    /**
     * Set outlet_id
     *
     * @param int $outlet_id
     * @return \Lof\Pos\Api\Data\OrderInterface
     */
    public function setOutletId($outlet_id);

    /**
     * Set user_id
     *
     * @param int $user_id
     * @return \Lof\Pos\Api\Data\OrderInterface
     */
    public function setUserId($user_id);

    /**
     * Set cashier_id
     *
     * @param int $cashier_id
     * @return \Lof\Pos\Api\Data\OrderInterface
     *
     */
    public function setCashierId($cashier_id);

    /**
     * Set cashier_name
     *
     * @param string $cashier_name
     * @return \Lof\Pos\Api\Data\OrderInterface
     */
    public function setCashierName($cashier_name);

    /**
     * Set cashier_phone
     *
     * @param string $cashier_phone
     * @return \Lof\Pos\Api\Data\OrderInterface
     */
    public function setCashierPhone($cashier_phone);

    /**
     * Set cashier_email
     *
     * @param string $cashier_email
     * @return \Lof\Pos\Api\Data\OrderInterface
     */
    public function setCashierEmail($cashier_email);

    /**
     * Set cashier_address
     *
     * @param string $cashier_address
     * @return \Lof\Pos\Api\Data\OrderInterface
     */
    public function setCashierAddress($cashier_address);

    /**
     * Set created_at
     *
     * @param string $created_at
     * @return \Lof\Pos\Api\Data\OrderInterface
     */
    public function setCreatedAt($created_at);

    /**
     * Set grand_total
     *
     * @param int $grand_total
     * @return \Lof\Pos\Api\Data\OrderInterface
     */
    public function setGrandTotal($grand_total);

    /**
     * Get OrderStatus
     *
     * @return string
     */
    public function getOrderStatus();

    /**
     * Set OrderStatus
     * @param int $order_status
     * @return string
     */
    public function setOrderStatus($order_status);
}

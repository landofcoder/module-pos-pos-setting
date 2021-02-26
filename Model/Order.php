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

use Lof\Pos\Api\Data\OrderInterface;

class Order extends \Magento\Framework\Model\AbstractModel implements OrderInterface
{
    protected $_eventPrefix = 'lof_pos_order';

    public function _construct()
    {
        $this->_init("Lof\Pos\Model\ResourceModel\Order");
    }

    /**
     * Retrieve cashier model with cashier data
     */
    public function getDataModel()
    {
        $orderData = $this->getData();
        return $orderData;
    }

    /**
     * Get ID
     *
     * @return int
     */
    public function getOrderId()
    {
        return parent::getData(self::POS_ORDER_ID);
    }

    /**
     * Get sales_order_id
     *
     * @return int
     */
    public function getSalesOrderId()
    {
        return parent::getData(self::SALES_ORDER_ID);
    }

    /**
     * Get outlet_id
     *
     * @return int
     */
    public function getOutletId()
    {
        return parent::getData(self::OUTLET_ID);
    }

    /**
     * Get user_id
     *
     * @return int
     */
    public function getUserId()
    {
        return parent::getData(self::USER_ID);
    }

    /**
     * Get cashier_id
     *
     * @return int
     *
     */
    public function getCashierId()
    {
        return parent::getData(self::CASHIER_ID);
    }

    /**
     * Get cashier_name
     *
     * @return string|null
     */
    public function getCashierName()
    {
        return parent::getData(self::CASHIER_NAME);
    }

    /**
     * Get cashier_phone
     *
     * @return string|null
     */
    public function getCashierPhone()
    {
        return parent::getData(self::CASHIER_PHONE);
    }

    /**
     * Get cashier_email
     *
     * @return string|null
     */
    public function getCashierEmail()
    {
        return parent::getData(self::CASHIER_EMAIL);
    }

    /**
     * Get cashier_address
     *
     * @return string|null
     */
    public function getCashierAddress()
    {
        return parent::getData(self::CASHIER_ADDRESS);
    }

    /**
     * Get created_at
     *
     * @return string|null
     */
    public function getCreatedAt(){
        return parent::getData(self::CREATED_AT);
    }

    /**
     * Get grand_total
     *
     * @return int|null
     */
    public function getGrandTotal(){
        return parent::getData(self::GRAND_TOTAL);
    }

    /**
     * Set ID
     *
     * @param int $id
     * @return \Lof\Pos\Api\Data\OrderInterface
     */
    public function setOrderId($id)
    {
        return $this->setData(self::POS_ORDER_ID, $id);
    }

    /**
     * Set sales_order_id
     *
     * @param int $sales_order_id
     * @return \Lof\Pos\Api\Data\OrderInterface
     */
    public function setSalesOrderId($sales_order_id)
    {
        return $this->setData(self::SALES_ORDER_ID, $sales_order_id);
    }

    /**
     * Set outlet_id
     *
     * @param int $outlet_id
     * @return \Lof\Pos\Api\Data\OrderInterface
     */
    public function setOutletId($outlet_id)
    {
        return $this->setData(self::OUTLET_ID, $outlet_id);
    }

    /**
     * Set user_id
     *
     * @param int $user_id
     * @return \Lof\Pos\Api\Data\OrderInterface
     */
    public function setUserId($user_id)
    {
        return $this->setData(self::USER_ID, $user_id);
    }

    /**
     * Set cashier_id
     *
     * @param int $cashier_id
     * @return \Lof\Pos\Api\Data\OrderInterface
     *
     */
    public function setCashierId($cashier_id)
    {
        return $this->setData(self::CASHIER_ID, $cashier_id);
    }

    /**
     * Set cashier_name
     *
     * @param string $cashier_name
     * @return \Lof\Pos\Api\Data\OrderInterface
     */
    public function setCashierName($cashier_name)
    {
        return $this->setData(self::CASHIER_NAME, $cashier_name);
    }

    /**
     * Set cashier_phone
     *
     * @param string $cashier_phone
     * @return \Lof\Pos\Api\Data\OrderInterface
     */
    public function setCashierPhone($cashier_phone)
    {
        return $this->setData(self::CASHIER_PHONE, $cashier_phone);
    }

    /**
     * Set cashier_email
     *
     * @param string $cashier_email
     * @return \Lof\Pos\Api\Data\OrderInterface
     */
    public function setCashierEmail($cashier_email)
    {
        return $this->setData(self::CASHIER_EMAIL, $cashier_email);
    }

    /**
     * Set cashier_address
     *
     * @param string $cashier_address
     * @return \Lof\Pos\Api\Data\OrderInterface
     */
    public function setCashierAddress($cashier_address)
    {
        return $this->setData(self::CASHIER_ADDRESS, $cashier_address);
    }

    /**
     * Set created_at
     *
     * @param string $created_at
     * @return \Lof\Pos\Api\Data\OrderInterface
     */
    public function setCreatedAt($created_at){
        return $this->setData(self::CREATED_AT, $created_at);
    }

    /**
     * Set grand_total
     *
     * @param int $grand_total
     * @return \Lof\Pos\Api\Data\OrderInterface
     */
    public function setGrandTotal($grand_total){
        return $this->setData(self::GRAND_TOTAL, $grand_total);
    }

    /**
     * Get OrderStatus
     *
     * @return string
     */
    public function getOrderStatus(){
        return parent::getData(self::ORDER_STATUS);
    }

    /**
     * Set OrderStatus
     * @param int $order_status
     * @return string
     */
    public function setOrderStatus($order_status){
        return $this->setData(self::ORDER_STATUS, $order_status);
    }
}

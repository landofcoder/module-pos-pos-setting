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

namespace Lof\Pos\Observer;

use Magento\Framework\Event\ObserverInterface;
use Lof\Pos\Model\OrderFactory;

class Observer implements ObserverInterface
{

    protected $request;
    protected $connector;
    protected $_orderFactory;
    protected $_userContext;

    public function __construct(\Magento\Framework\Webapi\Rest\Request $request,
                                OrderFactory $orderFactory,
                                \Magento\Authorization\Model\UserContextInterface $userContext)
    {
        $this->request = $request;
        $this->_orderFactory = $orderFactory;
        $this->_userContext = $userContext;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();
        $orderStatus = $order->getStatus();
        if ($orderStatus == "pending") {
            $dataRequest = $this->request->getBodyParams();
            $dataRequest['sales_order_id'] = $order->getId();
            $dataRequest['user_id'] = $this->_userContext->getUserId();
            $dataRequest['grand_total'] = $order->getBase_grand_total();
            $model = $this->_orderFactory->create();
            $model->setData($dataRequest);
            $model->save();
        }
    }
}
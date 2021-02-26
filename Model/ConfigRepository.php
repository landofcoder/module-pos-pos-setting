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

use Lof\Pos\Api\ConfigRepositoryInterface;
use Magento\Catalog\Model\ProductRepository;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Json\Helper\Data;
use Magento\Framework\Module\Manager;
use Magento\Quote\Api\CartManagementInterface;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Quote\Model\Cart\CartTotalRepository;
use Magento\Quote\Model\QuoteManagement;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\Store;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;

class ConfigRepository implements ConfigRepositoryInterface
{

    /**
     * @var ScopeConfigInterface
     */
    protected $_config;

    /**
     * @var StoreManagerInterface
     */
    private $storeManagerInterface;

    /**
     * @var Data
     */
    private $jsonHelper;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var CartManagementInterface
     */
    private $cartManagementInterface;

    /**
     * @var CartRepositoryInterface
     */
    private $cartRepositoryInterface;

    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @var CartTotalRepository
     */
    private $cartTotalRepository;

    /**
     * @var QuoteManagement
     */
    private $quoteManagement;

    /**
     * @var Manager
     */
    private $moduleManager;

    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepositoryInterface;

    /**
     * ConfigRepositoryInterface constructor.
     * @param ScopeConfigInterface $config
     * @param StoreManagerInterface $storeManager
     * @param Data $jsonHelper
     * @param LoggerInterface $logger
     * @param CartManagementInterface $cartManagementInterface
     * @param CartRepositoryInterface $cartRepositoryInterface
     * @param ProductRepository $productRepository
     * @param CartTotalRepository $cartTotalRepository
     * @param QuoteManagement $quoteManagement
     * @param Manager $moduleManager
     * @param CustomerRepositoryInterface $customerRepositoryInterface
     */
    public function __construct(
        ScopeConfigInterface $config,
        StoreManagerInterface $storeManager,
        Data $jsonHelper,
        LoggerInterface $logger,
        CartManagementInterface $cartManagementInterface,
        CartRepositoryInterface $cartRepositoryInterface,
        ProductRepository $productRepository,
        CartTotalRepository $cartTotalRepository,
        QuoteManagement $quoteManagement,
        Manager $moduleManager,
        CustomerRepositoryInterface $customerRepositoryInterface
    ) {
        $this->storeManagerInterface = $storeManager;
        $this->_config = $config;
        $this->jsonHelper = $jsonHelper;
        $this->logger = $logger;
        $this->cartManagementInterface = $cartManagementInterface;
        $this->cartRepositoryInterface = $cartRepositoryInterface;
        $this->productRepository = $productRepository;
        $this->cartTotalRepository = $cartTotalRepository;
        $this->quoteManagement = $quoteManagement;
        $this->moduleManager = $moduleManager;
        $this->customerRepositoryInterface = $customerRepositoryInterface;
    }

    /**
     * Get System Config.
     * @return array
     */
    public function getSystemConfig()
    {
        /** @var $store Store */
        $data_config['data_config'] = [];
        $data_config['data_config']['general_configuration'] = $this->_config->getValue("section_lofpos/general_configuration", ScopeInterface::SCOPE_STORE);
        $data_config['data_config']['default_guest_checkout'] = $this->_config->getValue("section_lofpos/default_guest_checkout", ScopeInterface::SCOPE_STORE);
        $data_config['data_config']['payment_for_pos'] = $this->_config->getValue("section_lofpos/payment_for_pos", ScopeInterface::SCOPE_STORE);
        $data_config['data_config']['shipping_method'] = $this->_config->getValue("section_lofpos/shipping_method", ScopeInterface::SCOPE_STORE);
        $data_config['data_config']['stripe_settings'] = $this->_config->getValue("section_lofpos/stripe_settings", ScopeInterface::SCOPE_STORE);
        $data_config['data_config']['authorize_settings'] = $this->_config->getValue("section_lofpos/authorize_settings", ScopeInterface::SCOPE_STORE);
        return $data_config;
    }

    /**
     * @return array
     */
    public function getShopInfo()
    {
        return ['currencyCode' => $this->getMainCurrencyCode()];
    }

    /**
     * Get discount quote
     * @param $params
     * @return mixed|void
     * @throws CouldNotSaveException
     * @throws NoSuchEntityException
     */
    public function createQuoteCheckout($params)
    {
        $shippingMethod = $this->_config->getValue("section_lofpos/shipping_method", ScopeInterface::SCOPE_STORE);
        $paymentMethod = $this->_config->getValue("section_lofpos/payment_for_pos", ScopeInterface::SCOPE_STORE);
        $defaultGuestCheckout = $this->_config->getValue("section_lofpos/default_guest_checkout", ScopeInterface::SCOPE_STORE);

        $defaultShippingMethod = $shippingMethod['default_shipping_method'];
        $defaultPaymentMethod = $paymentMethod['default_payment_method'];

        $jsonData = $this->jsonHelper->jsonDecode($params);
        $cartList = $jsonData['cart'];
        $customerId = $jsonData['customerId'];

        if (sizeof($cartList) > 0) {
            $store = $this->storeManagerInterface->getStore();
            $cartId = $this->cartManagementInterface->createEmptyCart();

            $quote = $this->cartRepositoryInterface->get($cartId);
            $quote->setStore($store);

            // Create quote with customer
            if ($customerId === 0 || !$customerId) {
                $customerId = $defaultGuestCheckout['customer_id'];
            }

            try {
                $customer = $this->customerRepositoryInterface->getById($customerId);
            } catch (NoSuchEntityException $e) {
                return 1;
            } catch (LocalizedException $e) {
                return 1;
            }
            $quote->assignCustomer($customer);

            // Add items in quote
            foreach ($cartList as $item) {
                $product = $this->productRepository->getById($item['id']);
                $quote->addProduct($product, $item['pos_qty']);
            }

            $shippingAddress = $quote->getShippingAddress();
            $shippingAddress->setCollectShippingRates(true)->collectShippingRates()->setShippingMethod($defaultShippingMethod);

            $quote->setPaymentMethod($defaultPaymentMethod);
            $quote->setInventoryProcessed(false);

            // Set Sales Order Payment
            $quote->getPayment()->importData(['method' => $defaultPaymentMethod]);

            // Save quote
            $quote->collectTotals()->save();
            $quote->save();
            return ['data' =>  ['cartId' => $quote->getId(), 'itemNumber' => $quote->getItemsCount()]];
        }
        return 1;
    }

    /**
     * @param string $params
     * @return mixed|void
     */
    public function posApplyDiscountCode($params)
    {
        $jsonData = $this->jsonHelper->jsonDecode($params);
        $cartId = $jsonData['cartId'];
        $couponCode = $jsonData['couponCode'];

        $result = ['data' => ['status' => true, 'applyStatus' => false]];

        try {
            $quote = $this->cartRepositoryInterface->get($cartId);

            // Check grand price before and after
            $grandTotalBefore = $quote->getGrandTotal();

            // Apply coupon
            $quote->setCouponCode($couponCode)->collectTotals()->save();
            $grandTotalAfter = $quote->getGrandTotal();

            // Apply success
            if ($grandTotalAfter < $grandTotalBefore) {
                $result = $result['data']['applyStatus'] = true;
            }
        } catch (NoSuchEntityException $e) {
            echo $e->getMessage();
            $result = $result['data']['status'] = false;
        }
        return $result;
    }

    /**
     * @return mixed|void
     */
    public function checkAllModuleInstalled()
    {
        $moduleAllInstalled = $this->moduleManager->isEnabled('Lof_All');
        $moduleCashier = $this->moduleManager->isEnabled('Lof_Cashier');
        $moduleOutlet = $this->moduleManager->isEnabled('Lof_Outlet');
        $modulePosReceipt = $this->moduleManager->isEnabled('Lof_PosReceipt');
        return [
            'data' => [
                'module-all' => $moduleAllInstalled,
                'module-cashier' => $moduleCashier,
                'module-outlet' => $moduleOutlet,
                'module-receipt' => $modulePosReceipt
            ]
        ];
    }

    /**
     * @return mixed
     */
    public function getMainCurrencyCode()
    {
        $currentCurrencyCode = "";
        $baseCurrencyCode = "";
        $allowedCurrencies = "";
        try {
            $baseCurrencyCode = $this->storeManagerInterface->getStore()->getBaseCurrencyCode();
            $currentCurrencyCode = $this->storeManagerInterface->getStore()->getCurrentCurrencyCode();
            $allowedCurrencies = $this->storeManagerInterface->getStore()->getAvailableCurrencyCodes(true);
        } catch (NoSuchEntityException $e) {
            $this->logger->error($e->getMessage());
        }

        if (isset($allowedCurrencies) && sizeof($allowedCurrencies) > 1) {
            $mainCurrencyCode = $currentCurrencyCode;
        } else {
            $mainCurrencyCode = $baseCurrencyCode;
        }
        return $mainCurrencyCode;
    }
}

<?php

declare(strict_types=1);

namespace Lof\Pos\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlAuthorizationException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Lof\Pos\Model\ConfigRepository;
use Magento\GraphQl\Model\Query\ContextInterface;


/**
 * Class PosConfiguration
 * @package Lof\Pos\Model\Resolver
 */
class PosConfiguration implements ResolverInterface
{
    /**
     * @var ConfigRepository
     */
    private $configRepository;

    public function __construct(
        ConfigRepository $configRepository
    ) {
        $this->configRepository = $configRepository;
    }

    /**
     * @inheritDoc
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        /** @var ContextInterface $context */
        if (!$context->getUserId()) {
            throw new GraphQlAuthorizationException(__('The current user isn\'t authorized.'));
        }
        $config = $this->configRepository->getSystemConfig();
        $general = $config['data_config']['general_configuration'];
        $guestCheckout = $config['data_config']['default_guest_checkout'];
        $payment = $config['data_config']['payment_for_pos'];
        $shipping = $config['data_config']['shipping_method'];
        $stripe = $config['data_config']['stripe_settings'];
        $author = $config['data_config']['authorize_settings'];
        return [
            'enabled' => $general['module_enabled'],
            'pos_title' => $general['pos_title'],
            'enable_offline_mode' => $general['enable_offline_mode'],
            'choose_attribute_for_barcode' => $general['choose_attribute_for_barcode'],
            'web_pos_color' => $general['web_pos_color'],
            'default_guest_checkout' => $guestCheckout['customer_id'],
            'applicable_payments' => isset($payment['applicable_payments']) ? $payment['applicable_payments'] : '',
            'specific_payments' => isset($payment['specific_payments']) ? $payment['specific_payments'] : '',
            'default_payment_method' => $payment['default_payment_method'],
            'applicable_shipping_methods' => isset($shipping['default_shipping_method']) ? $shipping['default_shipping_method'] : '',
            'specific_shipping_methods' => isset($shipping['specific_shipping_methods']) ? $shipping['specific_shipping_methods'] : '',
            'mark_as_shipped_by_default' => isset($shipping['mark_as_shipped_by_default']) ? $shipping['mark_as_shipped_by_default'] : '',
            'default_shipping_method' => $shipping['default_shipping_method'],
            'stripe_api_key' => isset($stripe['api_key']) ? $stripe['api_key'] : '',
            'authorize_login_id' => isset($author['login_id']) ? $author['login_id'] : '',
            'authorize_transaction_key' => isset($author['transaction_key']) ? $author['transaction_key'] : '',
        ];
    }
}

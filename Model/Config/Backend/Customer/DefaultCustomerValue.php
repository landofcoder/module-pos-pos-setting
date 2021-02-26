<?php

namespace Lof\Pos\Model\Config\Backend\Customer;

class DefaultCustomerValue extends \Magento\Framework\App\Config\Value
{

    const CUSTOMER_ID = 'section_lofpos/default_guest_checkout/customer_id';
    const FIRST_NAME = 'section_lofpos/default_guest_checkout/first_name';
    const LAST_NAME = 'section_lofpos/default_guest_checkout/last_name';
    const STREET = 'section_lofpos/default_guest_checkout/street';
    const COUNTRY_ID = 'section_lofpos/default_guest_checkout/country_id';
    const CITY = 'section_lofpos/default_guest_checkout/city';
    const POST_CODE = 'section_lofpos/default_guest_checkout/post_code';
    const TELEPHONE = 'section_lofpos/default_guest_checkout/telephone';
    const EMAIL = 'section_lofpos/default_guest_checkout/email';

    /**
     * @var \Magento\Framework\App\Config\ValueFactory
     */
    protected $_configValueFactory;

    /**
     * @var string
     */
    protected $_runModelPath = '';
    protected $scopeConfig;
    protected $_customerFactory;

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $config
     * @param \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList
     * @param \Magento\Framework\App\Config\ValueFactory $configValueFactory
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb $resourceCollection
     * @param string $runModelPath
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\App\Config\ScopeConfigInterface $config,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
        \Magento\Framework\App\Config\ValueFactory $configValueFactory,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        $runModelPath = '',
        array $data = []
    )
    {
        $this->scopeConfig = $scopeConfig;
        $this->_runModelPath = $runModelPath;
        $this->_configValueFactory = $configValueFactory;
        $this->_customerFactory = $customerFactory;
        parent::__construct($context, $registry, $config, $cacheTypeList, $resource, $resourceCollection, $data);
    }

    /**
     * @inheritdoc
     *
     * @return $this
     * @throws \Exception
     */
    public function afterSave()
    {
        $customer_id = $this->getValue();
        $data = $this->_customerFactory->create()
            ->getCollection()->getItemById($customer_id);
        $address = $data->getAddresses();
        $dataCustomer = [];
        foreach ($address as $item) {
            $dataCustomer = $item->toArray();
        }
        try {
            $this->_configValueFactory->create()->load(
                self::CUSTOMER_ID,
                'path'
            )->setValue(
                $data->getEntity_id()
            )->setPath(
                self::CUSTOMER_ID
            )->save();

            $this->_configValueFactory->create()->load(
                self::FIRST_NAME,
                'path'
            )->setValue(
                $data->getFirstname()
            )->setPath(
                self::FIRST_NAME
            )->save();

            $this->_configValueFactory->create()->load(
                self::LAST_NAME,
                'path'
            )->setValue(
                $data->getLastname()
            )->setPath(
                self::LAST_NAME
            )->save();

            $this->_configValueFactory->create()->load(
                self::STREET,
                'path'
            )->setValue(
                isset($dataCustomer['street']) ? $dataCustomer['street'] : ''
            )->setPath(
                self::STREET
            )->save();

            $this->_configValueFactory->create()->load(
                self::COUNTRY_ID,
                'path'
            )->setValue(
                isset($dataCustomer['country_id']) ? $dataCustomer['country_id'] : ''
            )->setPath(
                self::COUNTRY_ID
            )->save();

            $this->_configValueFactory->create()->load(
                self::CITY,
                'path'
            )->setValue(
                isset($dataCustomer['city']) ? $dataCustomer['city'] : ''
            )->setPath(
                self::CITY
            )->save();

            $this->_configValueFactory->create()->load(
                self::POST_CODE,
                'path'
            )->setValue(
                isset($dataCustomer['postcode']) ? $dataCustomer['postcode'] : ''
            )->setPath(
                self::POST_CODE
            )->save();

            $this->_configValueFactory->create()->load(
                self::TELEPHONE,
                'path'
            )->setValue(
                isset($dataCustomer['telephone']) ? $dataCustomer['telephone'] : ''
            )->setPath(
                self::TELEPHONE
            )->save();

            $this->_configValueFactory->create()->load(
                self::EMAIL,
                'path'
            )->setValue(
                $data->getEmail()
            )->setPath(
                self::EMAIL
            )->save();
        } catch (\Exception $e) {
            throw new \Exception(__('We can\'t save the cron expression.'));
        }

        return parent::afterSave();
    }
}
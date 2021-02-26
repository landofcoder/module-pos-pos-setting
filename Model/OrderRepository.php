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

use Lof\Pos\Api\Data;
use Lof\Pos\Api\OrderRepositoryInterface;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Reflection\DataObjectProcessor;
use Lof\Pos\Model\ResourceModel\Order as ResourceOrder;
use Lof\Pos\Model\ResourceModel\Order\CollectionFactory as orderCollectionFactory;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class OrderRepository
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class OrderRepository implements OrderRepositoryInterface
{
    /**
     * @var ResourceOrder
     */
    protected $resource;

    /**
     * @var OrderFactory
     */
    protected $orderFactory;

    /**
     * @var orderCollectionFactory
     */
    protected $orderCollectionFactory;

    /**
     * @var Data\OrderSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * @var \Lof\Pos\Api\Data\OrderInterfaceFactory
     */
    protected $dataOrderFactory;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    protected $orderRepository;

    /**
     * @param ResourceOrder $resource
     * @param OrderFactory $orderFactory
     * @param Data\OrderInterfaceFactory $dataOrderFactory
     * @param orderCollectionFactory $orderCollectionFactory
     * @param Data\OrderSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     * @param \Magento\Sales\Api\OrderRepositoryInterface $orderRepository
     */
    public function __construct(
        ResourceOrder $resource,
        OrderFactory $order,
        Data\OrderInterfaceFactory $dataOrderFactory,
        orderCollectionFactory $orderCollectionFactory,
        Data\OrderSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor = null,
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepository
    )
    {
        $this->resource = $resource;
        $this->orderFactory = $order;
        $this->orderCollectionFactory = $orderCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->orderFactory = $dataOrderFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
        $this->collectionProcessor = $collectionProcessor ?: $this->getCollectionProcessor();
        $this->orderRepository = $orderRepository;
    }


    /**
     * Load order data collection by given search criteria
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @param \Magento\Framework\Api\SearchCriteriaInterface $criteria
     * @return \Lof\Pos\Api\Data\OrderSearchResultsInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $criteria)
    {
        /** @var \Lof\Pos\Model\ResourceModel\Order\Collection $collection */
        $collection = $this->orderCollectionFactory->create();

        $this->collectionProcessor->process($criteria, $collection);

        /** @var Data\OrderSearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        foreach ($collection->getItems() as $data){
            $data['order_status'] = $this->orderRepository->get($data['sales_order_id'])->getStatus();
        }
        return $searchResults;
    }


    /**
     * Retrieve collection processor
     *
     * @return CollectionProcessorInterface
     * @deprecated 102.0.0
     */
    private function getCollectionProcessor()
    {
        if (!$this->collectionProcessor) {
            $this->collectionProcessor = \Magento\Framework\App\ObjectManager::getInstance()->get(
                'Magento\Cms\Model\Api\SearchCriteria\PageCollectionProcessor'
            );
        }
        return $this->collectionProcessor;
    }
}

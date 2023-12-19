<?php
/**
 * @category Arun
 * @package Arun_CustomerProfile
 * @copyright Copyright (c) 2023 Arun
 * @author Arun
 */
namespace Arun\CustomerProfile\Ui\Component\Listing\Column;

use Magento\Customer\Model\CustomerFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Asset\Repository;

class CustomerProfile extends Column
{
    /**
     * @var Magento\Customer\Model\CustomerFactory $block
     */
    protected $customerFactory;

    /**
     * @var \Magento\Framework\View\Asset\Repository
     */
    protected $assetRepo;

    /**
     * @var Magento\Framework\UrlInterface
     */
    private $urlBuilder;

    /**
     * @param Repository $assetRepo
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param CustomerFactory $customerFactory
     * @param UrlInterface $urlBuilder
     * @param array $data
     */
    public function __construct(
        Repository $assetRepo,
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        CustomerFactory $customerFactory,
        UrlInterface $urlBuilder,
        array $components = [], array $data = [])
    {
        $this->assetRepo = $assetRepo;
        $this->customerFactory = $customerFactory;
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $customer = $this->customerFactory->create()->load($item["entity_id"]);
                $fileName = $customer->getData('customer_profile');
                if($fileName != ''){
                $item[$this->getData('name')] = '<img height="48" width="48" src='.$this->urlBuilder->getBaseUrl(['_type' => UrlInterface::URL_TYPE_MEDIA]).'customer'.$fileName.'>';
                }else{
                $fileName = $this->assetRepo->getUrl('Magento_Catalog::images/product/placeholder/image.jpg');
                $item[$this->getData('name')] = '<img height="48" width="48" src='.$fileName.'>';
                }
        }
    }
        return $dataSource;
    }
}
<?php
/**
 * @category Arun
 * @package Arun
 * @copyright Copyright (c) 2023 Arun
 * @author Arun
 */
namespace Arun\CustomerProfile\Block\Customer;
 
use Magento\Backend\Block\Template\Context;
use Magento\Framework\UrlInterface;
use Magento\Customer\Model\SessionFactory;
use Magento\Framework\View\Element\Template;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Customer\Model\Customer;
use Magento\Framework\View\Asset\Repository;
 
class Account extends Template
{    
    /**
     * @var Magento\Framework\UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var Magento\Customer\Model\SessionFactory
     */
    protected $customerSession;

    /**
     * @var Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var Magento\Customer\Model\Customer
     */
    protected $customerModel;

    /**
     * @var \Magento\Framework\View\Asset\Repository
     */
    protected $assetRepo;

    /**
     * @param Context $context
     * @param UrlInterface $urlBuilder
     * @param SessionFactory $customerSession
     * @param StoreManagerInterface $storeManager
     * @param Customer $customerModel
     * @param Repository $assetRepo
     * @param array $data
     */
    public function __construct(
        Context $context,
        UrlInterface $urlBuilder,
        SessionFactory $customerSession,
        StoreManagerInterface $storeManager,
        Customer $customerModel,
        Repository $assetRepo,
        array $data = []
    )
    {
        $this->urlBuilder = $urlBuilder;
        $this->customerSession = $customerSession->create();
        $this->storeManager = $storeManager;
        $this->customerModel = $customerModel;
        $this->assetRepo = $assetRepo;
 
        parent::__construct($context, $data);
 
        $collection = $this->getContracts();
        $this->setCollection($collection);
    }
    
    public function getBaseUrl()
    {
        return $this->storeManager->getStore()->getBaseUrl();
    }

    public function getMediaUrl()
    {
        return $this->getBaseUrl() . 'pub/media/';
    }

    public function getCustomerImageUrl($filePath)
    {
        return $this->getMediaUrl() . 'customer' . $filePath;
    }

    public function getCustomerData()
    {
        return $this->customerModel;
    }

    public function getDefaultImage()
    {
        return $this->assetRepo->getUrl('Magento_Catalog::images/product/placeholder/image.jpg');
    }

    public function getCurrentCustomer()
    {
        return $this->customerSession->getId();
    }

    public function getFileUrl()
    {
        $customerData = $this->customerModel->load($this->customerSession->getId());
        $url = $customerData->getData('customer_profile');
        if (!empty($url)) {
            return $this->getCustomerImageUrl($url);
        }
        return false;
    }
}

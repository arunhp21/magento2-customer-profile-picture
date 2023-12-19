<?php
/**
 * @category Arun
 * @package Arun
 * @copyright Copyright (c) 2023 Arun
 * @author Arun
 */
namespace Arun\CustomerProfile\CustomerData;

use Magento\Customer\CustomerData\SectionSourceInterface;
use Magento\Framework\UrlInterface;
use Magento\Customer\Model\SessionFactory;
use Magento\Framework\View\Element\Template;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Customer\Model\Customer;

class Profile implements SectionSourceInterface
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
     * @param UrlInterface $urlBuilder
     * @param SessionFactory $customerSession
     * @param StoreManagerInterface $storeManager
     * @param Customer $customerModel
     * @param array $data
     */
    public function __construct(
        UrlInterface $urlBuilder,
        SessionFactory $customerSession,
        StoreManagerInterface $storeManager,
        Customer $customerModel,
        array $data = []
    )
    {
        $this->urlBuilder = $urlBuilder;
        $this->customerSession = $customerSession->create();
        $this->storeManager = $storeManager;
        $this->customerModel = $customerModel;
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
    
    public function getSectionData()
    {
        $customerData = $this->customerModel->load($this->customerSession->getId());
        $url = $customerData->getData('customer_profile');
        if (!empty($url)) {
            $data = ['profile' => $this->getCustomerImageUrl($url) ];
            return $data;
        }
        return false;
    }
}

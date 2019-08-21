<?php

namespace IsobarNZ\CustomAttribute\Block\Customer\Address\Form\Edit;

use IsobarNZ\CustomAttribute\Block\Customer\Widget\Custom as CustomWidget;
use Magento\Customer\Api\AddressRepositoryInterface;
use Magento\Customer\Api\Data\AddressInterface;
use Magento\Customer\Model\AddressFactory;
use Magento\Customer\Model\Session;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template;

class Custom extends Template
{
    /**
     * @var AddressInterface
     */
    protected $address = null;

    /**
     * @var AddressRepositoryInterface
     */
    protected $addressRepository = null;

    /**
     * @var AddressFactory
     */
    protected $addressFactory = null;

    /**
     * @var Session
     */
    protected $customerSession;

    public function __construct(Template\Context $context, AddressRepositoryInterface $addressRepository, AddressFactory $addressFactory, Session $customerSession, array $data = [])
    {
        parent::__construct($context, $data);
        $this->addressRepository = $addressRepository;
        $this->addressFactory = $addressFactory;
        $this->customerSession = $customerSession;
    }

    /**
     * @return Template
     * @throws LocalizedException
     */
    protected function _prepareLayout()
    {
        $addressId = $this->getRequest()->getParam('id');

        if ($addressId) {
            try {
                $this->address = $this->addressRepository->getById($addressId);
                if ($this->address->getCustomerId() !== $this->customerSession->getCustomerId()) {
                    $this->address = null;
                }
            } catch (NoSuchEntityException $exception) {
                $this->address = null;
            }
        }

        if (!$this->address) {
            $this->address = $this->addressFactory->create();
        }

        return parent::_prepareLayout();
    }


    /**
     * @return string
     * @throws LocalizedException
     */
    protected function _toHtml()
    {
        /** @var CustomWidget $customWidgetBlock */
        $customWidgetBlock = $this->getLayout()->createBlock(CustomWidget::class);
        $customWidgetBlock->setAddress($this->address);
        return $customWidgetBlock->toHtml();
    }
}

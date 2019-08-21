<?php

namespace IsobarNZ\CustomAttribute\Block\Customer\Widget;

use Magento\Customer\Api\AddressMetadataInterface;
use Magento\Customer\Api\Data\AddressInterface;
use Magento\Customer\Api\Data\AttributeMetadataInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template;

class Custom extends Template
{
    /**
     * @var AddressMetadataInterface
     */
    protected $addressMetadata;

    const ATTRIBUTE_NAME = 'custom';

    public function __construct(Template\Context $context, AddressMetadataInterface $addressMetadata, array $data = [])
    {
        parent::__construct($context, $data);
        $this->setTemplate('widget/custom.phtml');
        $this->addressMetadata = $addressMetadata;
    }

    /**
     * @return string
     */
    public function getFieldId()
    {
        return self::ATTRIBUTE_NAME;
    }

    /**
     * @return bool
     * @throws LocalizedException
     */
    public function isRequired()
    {
        $attribute = $this->getAttribute();
        return $attribute ? $attribute->isRequired() : false;
    }

    /**
     * @return string
     */
    public function getFieldName()
    {
        return self::ATTRIBUTE_NAME;
    }

    /**
     * @return \Magento\Framework\Phrase|string
     * @throws LocalizedException
     */
    public function getFieldLabel()
    {
        $attribute = $this->getAttribute();
        return $attribute
            ? $attribute->getFrontendLabel()
            : __('Custom');
    }

    public function getValue()
    {
        $address = $this->getAddress();
        if (!$address) {
            return null;
        }

        $custom = $address->getCustomAttribute(self::ATTRIBUTE_NAME);
        if (!$custom) {
            return null;
        }

        return $custom->getValue();
    }

    /**
     * @return AttributeMetadataInterface
     * @throws LocalizedException
     */
    protected function getAttribute()
    {
        try {
            $attribute = $this->addressMetadata->getAttributeMetadata(self::ATTRIBUTE_NAME);
        } catch (NoSuchEntityException $ex) {
            $attribute = null;
        }
        return $attribute;
    }

    /**
     * @return AddressInterface
     */
    public function getAddress()
    {
        return $this->getData('address');
    }

    /**
     * @param AddressInterface $address
     * @return $this
     */
    public function setAddress(AddressInterface $address)
    {
        return $this->setData('address', $address);
    }
}

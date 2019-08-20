<?php

namespace IsobarNZ\CustomAttribute\Plugin\Customer;

use IsobarNZ\CustomAttribute\Block\Customer\Address\Form\Edit\Custom;
use Magento\Customer\Block\Address\Edit;
use Magento\Framework\View\LayoutInterface;

class AddressEditPlugin
{

    /**
     * @var LayoutInterface
     */
    protected $layout;

    /**
     * AddressEditPlugin constructor.
     * @param LayoutInterface $layout
     */
    public function __construct(LayoutInterface $layout)
    {
        $this->layout = $layout;
    }

    /**
     * @param Edit   $edit
     * @param string $result
     * @return string
     */
    public function afterGetNameBlockHtml(Edit $edit, $result)
    {
        $customBlock = $this->layout->createBlock(Custom::class, 'isobarnz_customattribute');
        return $result . $customBlock->toHtml();

        /*
        <<<HTML
<div class="field custom">
<label class="label" for="custom"><span>Custom</span></label>
<div class="control">
    <input type="text" name="custom" title="Custom" class="input-text" id="custom" >
</div>
</div>
HTML;*/
    }
}

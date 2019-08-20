<?php

namespace IsobarNZ\CustomAttribute\Plugin\Customer;

use Magento\Customer\Block\Address\Edit;

class AddressEditPlugin
{
    /**
     * @param Edit   $edit
     * @param string $result
     * @return string
     */
    public function afterGetNameBlockHtml(Edit $edit, $result)
    {
        return $result . <<<HTML
<div class="field custom">
    <label class="label" for="custom"><span>Custom</span></label>
    <div class="control">
        <input type="text" name="custom" title="Custom" class="input-text" id="custom" >
    </div>
</div>
HTML;
    }
}

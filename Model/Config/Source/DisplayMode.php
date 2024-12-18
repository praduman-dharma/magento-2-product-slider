<?php

namespace Conceptive\ProductSlider\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class DisplayMode implements OptionSourceInterface
{
    /**
     * Retrieve options for Display Mode dropdown
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 'grid', 'label' => __('Grid')],
            ['value' => 'slider', 'label' => __('Slider')]
        ];
    }
}

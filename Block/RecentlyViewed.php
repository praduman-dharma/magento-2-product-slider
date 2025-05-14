<?php

namespace Conceptive\ProductSlider\Block;

use Magento\Catalog\Block\Widget\RecentlyViewed as CoreRecentlyViewed;

class RecentlyViewed extends CoreRecentlyViewed
{
    protected function _construct()
    {
        parent::_construct();
        
        // Override default values
        $this->setData('page_size', $this->getPageSize());
        // $this->setData('show_attributes', 'name,image,price,rating_summary');
    }


    /**
     * Override default page_size
     *
     * @return int
     */
    public function getPageSize()
    {
        $limit = $this->_scopeConfig->getValue(
            'productslider/general/product_limit',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );

        if (!$limit) {
            return $this->_scopeConfig->getValue(
                'catalog/recently_products/viewed_count',
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE
            );
        }

        return $limit;
    }
}

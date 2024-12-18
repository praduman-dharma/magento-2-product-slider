<?php

namespace Conceptive\ProductSlider\Block;

use Magento\Framework\App\ActionInterface;
use Magento\Catalog\Block\Product\AbstractProduct;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Conceptive\ProductSlider\Helper\Data as ProductSliderHelper;

class ProductList extends AbstractProduct
{
    protected $helper;
    protected $urlHelper;
    protected $productCollectionFactory;

    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Framework\Url\Helper\Data $urlHelper,
        CollectionFactory $productCollectionFactory,
        ProductSliderHelper $helper,
        array $data = []
    ) {
        $this->urlHelper = $urlHelper;
        $this->productCollectionFactory = $productCollectionFactory;
        $this->helper = $helper;
        parent::__construct($context, $data);
    }

    public function getProductCollection()
    {
        $limit = $this->helper->getProductLimit();
        $collection = $this->productCollectionFactory->create();
        $collection->addAttributeToSelect(['name', 'image', 'price', 'special_price'])
                    ->addAttributeToFilter('type_id', 'configurable')
                    ->addAttributeToFilter("visibility", ['neq' => 1])
                    ->setPageSize($limit);
        return $collection;
    }

    public function getAddToCartPostParams(\Magento\Catalog\Model\Product $product)
    {
        $url = $this->getAddToCartUrl($product, ['_escape' => false]);
        return [
            'action' => $url,
            'data' => [
                'product' => (int) $product->getEntityId(),
                ActionInterface::PARAM_NAME_URL_ENCODED =>
                $this->urlHelper->getEncodedUrl($url),
            ]
        ];
    }

    protected function getDetailsRendererList()
    {
        return $this->getDetailsRendererListName() ? $this->getLayout()->getBlock(
            $this->getDetailsRendererListName()
        ) : $this->getChildBlock(
            'product_slider_renderers'
        );
    }

    public function getConfigValue($field, $storeId = null)
    {
        return $this->helper->getConfigValue($field, $storeId);
    }
}

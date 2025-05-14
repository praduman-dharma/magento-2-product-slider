<?php

namespace Conceptive\ProductSlider\Controller\Product;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\Result\JsonFactory;
use Conceptive\ProductSlider\Block\ProductList;

class RecentlyViewed extends Action
{
    protected $resultPageFactory;
    protected $resultJsonFactory;
    protected $productList;

    public function __construct(
        Context $context,
        productList $productList,
        PageFactory $resultPageFactory,
        JsonFactory $resultJsonFactory
    ) {
        $this->productList = $productList;
        $this->resultPageFactory = $resultPageFactory;
        $this->resultJsonFactory = $resultJsonFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultJson = $this->resultJsonFactory->create();
        $productIds = $this->getRequest()->getParam('product_ids', []);

        if (!is_array($productIds) || empty($productIds)) {
            return $resultJson->setData(['success' => false, 'message' => 'No product IDs provided']);
        }

        $blockTitle = __('Recently Viewed by Ajax');

        $resultPage = $this->resultPageFactory->create();

        $resultContent = $resultPage->getLayout()
            ->createBlock('Conceptive\ProductSlider\Block\ProductList')
            ->setTemplate('Conceptive_ProductSlider::product_grid.phtml')
            ->setData('product_ids', $productIds)
            ->setData('block_title', $blockTitle)
            ->toHtml();

        return $resultJson->setData(['success' => true, 'products' => $resultContent]);
    }
}

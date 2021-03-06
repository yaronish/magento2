<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

/**
 * Wishlist sidebar block
 */
namespace Magento\Wishlist\Block\Customer;

use Magento\Catalog\Model\Product;
use Magento\Framework\Pricing\Render;

/**
 * @api
 */
class Sidebar extends \Magento\Wishlist\Block\AbstractBlock
{
    /**
     * Retrieve block title
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTitle()
    {
        return __('My Wish List');
    }

    /**
     * Return HTML block content
     *
     * @param Product $product
     * @param string $priceType
     * @param string $renderZone
     * @param array $arguments
     * @return string
     */
    public function getProductPriceHtml(
        Product $product,
        $priceType,
        $renderZone = Render::ZONE_ITEM_LIST,
        array $arguments = []
    ) {
        if (!isset($arguments['zone'])) {
            $arguments['zone'] = $renderZone;
        }

        $price = '';

        $priceRender = $this->getPriceRender();
        if ($priceRender) {
            $price = $priceRender->render($priceType, $product, $arguments);
        }

        return $price;
    }

    /**
     * Get price render block
     *
     * @return Render
     */
    private function getPriceRender()
    {
        /** @var Render $priceRender */
        $priceRender = $this->getLayout()->getBlock('product.price.render.default');
        if (!$priceRender) {
            $priceRender = $this->getLayout()->createBlock(
                \Magento\Framework\Pricing\Render::class,
                'product.price.render.default',
                [
                    'data' => [
                        'price_render_handle' => 'catalog_product_prices',
                    ],
                ]
            );
        }
        return $priceRender;
    }
}

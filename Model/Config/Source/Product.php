<?php

/**
 * @Author: Alex Dong
 * @Date:   2020-07-14 19:36:33
 * @Last Modified by:   nguyen
 * @Last Modified time: 2021-06-17 10:32:17
 */

namespace Magiccart\Testimonial\Model\Config\Source;

class Product
{
    
    /* Product collection */ 
    protected $productCollection;

    /**
     * Catalog product visibility
     *
     * @var \Magento\Catalog\Model\Product\Visibility
     */
    protected $catalogProductVisibility;

    public function __construct(     
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollection,
        \Magento\Catalog\Model\Product\Visibility $catalogProductVisibility,
        array $data = []
    )
    {    
        $this->productCollection= $productCollection;
        $this->catalogProductVisibility= $catalogProductVisibility;
    }
    
    public function getProductCollection()
    {

        $collection = $this->productCollection->create();
        $collection->addAttributeToSelect(['name', 'sku']);
        $collection->setVisibility($this->catalogProductVisibility->getVisibleInCatalogIds());

        return $collection;
    }

    public function toOptionArray()
    {
        $products = $this->getProductCollection();
        $options = [];
        if($products->getSize()){
            foreach ($products as $product) {
                $options[] = [
                    'value' => $product->getId(),
                    'label' => 'ID(' . $product->getId() . ') -> ' .  $product->getName()
                ];
            }
        }
        return $options;
    }

}

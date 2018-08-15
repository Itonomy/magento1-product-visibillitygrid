<?php

class Itonomy_ProductVisibilityGrid_Block_Adminhtml_ProductVisibilityGrid_Product extends Mage_Adminhtml_Block_Widget_Container
{

    /**
     * Set template
     */
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('itonomy/productvisibilitygrid/product.phtml');
    }

    /**
     * Prepare button and grid
     *
     * @return Itonomy_ProductVisibilityGrid_Block_Adminhtml_ProductVisibilityGrid_Product
     */
    protected function _prepareLayout()
    {
        $layout = $this->getLayout();

        $this->setChild('store_switcher', $layout->createBlock('adminhtml/store_switcher')->setUseConfirm(0));
        $this->setChild('grid',
            $layout->createBlock('productvisibilitygrid/adminhtml_productvisibilitygrid_product_grid'));

        parent::_prepareLayout();

        return $this;
    }

    /**
     * Check whether it is single store mode
     *
     * @return bool
     */
    public function isSingleStoreMode()
    {
        return Mage::app()->isSingleStoreMode();
    }
}

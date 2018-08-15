<?php

class Itonomy_ProductVisibilityGrid_Adminhtml_Productvisibilitygrid_IndexController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Request to the grid index.
     */
    public function indexAction()
    {
        $this->loadLayout();

        $title = Mage::helper('productvisibilitygrid')->__('Examine Product Visibility');
        $layout = $this->getLayout();

        $layout->getBlock('head')->setTitle($title);
        $this->_setActiveMenu('catalog');
        $this->_addContent($layout->createBlock('productvisibilitygrid/adminhtml_productvisibilitygrid_product'));

        $this->renderLayout();
    }

    /**
     * Request to the grid itself, to perform an AJAX update.
     */
    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()
                ->createBlock('productvisibilitygrid/adminhtml_productvisibilitygrid_product_grid')
                ->toHtml()
        );
    }

    /**
     * Request to reindex the flat data of a product.
     */
    public function reindexAction()
    {
        $productId = (int)$this->getRequest()->getParam('id');
        $storeId = $this->getRequest()->getParam('store');

        // Don't start the indexer if the product id is missing.
        if (!$productId) {
            $this->_getSession()->addError(Mage::helper('productvisibilitygrid')->__('Invalid request.'));
            $this->_redirectReferer('*/*/index');
            return;
        }

        $this->_reindex(array($productId));

        // Redirect back to the previous page (including filters).
        $this->_redirectReferer('*/*/index');
    }

    /**
     * Request to reindex the flat data of products.
     */
    public function massReindexAction()
    {
        $productIds = $this->getRequest()->getParam('product');

        if (empty($productIds)) {
            $this->_getSession()->addError($this->__('Please select product(s).'));
            $this->_redirectReferer('*/*/index');
            return;
        }

        $this->_reindex($productIds);

        // Redirect back to the previous page (including filters).
        $this->_redirectReferer('*/*/index');
    }

    /**
     * Starts the actual reindexing for the given product(s) and store.
     *
     * @param $productIds array Ids of products to reindex.
     * @param $storeId int Id of store to reindex for (optional).
     */
    protected function _reindex($productIds)
    {
        try {
            $indexer = Mage::getSingleton('index/indexer');
            foreach ($productIds as $productId) {
                // Load the product and set a force reindex required flag.
                $product = Mage::getModel('catalog/product')
                    ->load($productId)
                    ->setForceReindexRequired(true);
                // Imitate a product save action to initiate a full reindex.
                $indexer->processEntityAction($product, Mage_Catalog_Model_Product::ENTITY,
                    Mage_Index_Model_Event::TYPE_SAVE);
            }

            if (count($productIds) == 1) {
                $this->_getSession()->addSuccess($this->__('Product %s has been reindexed.', $productIds[0]));
            } else {
                $this->_getSession()->addSuccess($this->__('Selected products have been reindexed.'));
            }
        } catch (Mage_Core_Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        } catch (Exception $e) {
            $this->_getSession()->addException($e, $this->__('Cannot initialize the indexer process.'));
        }
    }

    /**
     * Check ACL permissions of admin user
     *
     * @return boolean
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('catalog/products');
    }
}

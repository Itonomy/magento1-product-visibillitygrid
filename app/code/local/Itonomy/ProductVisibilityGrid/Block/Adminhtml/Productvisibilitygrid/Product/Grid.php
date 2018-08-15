<?php

class Itonomy_ProductVisibilityGrid_Block_Adminhtml_Productvisibilitygrid_Product_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('productVisibilityGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
        $this->setVarNameFilter('product_filter');

    }

    /**
     * Returns the chosen store id.
     *
     * @return int Store id from the request if set, otherwise admin store id.
     */
    protected function _getStoreId()
    {
        return $this->getRequest()->getParam('store', Mage_Core_Model_App::ADMIN_STORE_ID);
    }

    /**
     * Prepares the collection.
     *
     * @return Itonomy_ProductVisibilityGrid_Block_Adminhtml_Productvisibilitygrid_Product_Grid
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('productvisibilitygrid/product_collection')
            ->setStoreId($this->_getStoreId())
            ->prepareSelect();

        $this->setCollection($collection);

        parent::_prepareCollection();

        return $this;
    }

    /**
     * Prepares the grid columns.
     *
     * @return Itonomy_ProductVisibilityGrid_Block_Adminhtml_Productvisibilitygrid_Product_Grid
     */
    protected function _prepareColumns()
    {
        $this->addColumn('entity_id',
            array(
                'header' => Mage::helper('productvisibilitygrid')->__('ID'),
                'width' => '100px',
                'type' => 'number',
                'index' => 'entity_id',
            ));
        $this->addColumn('name',
            array(
                'header' => Mage::helper('productvisibilitygrid')->__('Name'),
                'index' => 'name',
            ));

        $this->addColumn('type_id',
            array(
                'header' => Mage::helper('productvisibilitygrid')->__('Type'),
                'width' => '80px',
                'index' => 'type_id',
                'type' => 'options',
                'options' => Mage::getSingleton('catalog/product_type')->getOptionArray(),
            ));

        $this->addColumn('sku',
            array(
                'header' => Mage::helper('productvisibilitygrid')->__('SKU'),
                'width' => '120px',
                'index' => 'sku',
            ));

        $this->addColumn('in_flat_table',
            array(
                'header' => Mage::helper('productvisibilitygrid')->__('In Flat Table'),
                'width' => '80px',
                'index' => 'in_flat_table',
                'type' => 'options',
                'options' => Mage::getModel('eav/entity_attribute_source_boolean')->getOptionArray()
            ));

        if ($this->_getStoreId() != 0) {
            $this->addColumn('in_website',
                array(
                    'header' => Mage::helper('productvisibilitygrid')->__('In Website'),
                    'width' => '80px',
                    'index' => 'in_website',
                    'type' => 'options',
                    'options' => Mage::getModel('eav/entity_attribute_source_boolean')->getOptionArray()
                ));

            $this->addColumn('in_category',
                array(
                    'header' => Mage::helper('productvisibilitygrid')->__('In Category'),
                    'width' => '80px',
                    'index' => 'in_category',
                    'type' => 'options',
                    'options' => Mage::getModel('eav/entity_attribute_source_boolean')->getOptionArray()
                ));

            $this->addColumn('in_stock',
                array(
                    'header' => Mage::helper('productvisibilitygrid')->__('In Stock'),
                    'width' => '80px',
                    'index' => 'in_stock',
                    'type' => 'options',
                    'options' => Mage::getModel('eav/entity_attribute_source_boolean')->getOptionArray()
                ));

            $this->addColumn('in_price_index',
                array(
                    'header' => Mage::helper('productvisibilitygrid')->__('In Price Index'),
                    'width' => '80px',
                    'index' => 'in_price_index',
                    'type' => 'options',
                    'options' => Mage::getModel('eav/entity_attribute_source_boolean')->getOptionArray()
                ));

            $this->addColumn('visibility',
                array(
                    'header' => Mage::helper('productvisibilitygrid')->__('Visibility'),
                    'width' => '80px',
                    'index' => 'visibility',
                    'type' => 'options',
                    'options' => Mage::getModel('catalog/product_visibility')->getOptionArray()
                ));
        }

        $this->addColumn('status',
            array(
                'header' => Mage::helper('productvisibilitygrid')->__('Status'),
                'width' => '80px',
                'index' => 'status',
                'type' => 'options',
                'options' => Mage::getModel('catalog/product_status')->getOptionArray()
            ));

        $this->addColumn('action',
            array(
                'header' => Mage::helper('productvisibilitygrid')->__('Action'),
                'width' => '50px',
                'type' => 'action',
                'getter' => 'getId',
                'actions' => array(
                    array(
                        'caption' => Mage::helper('productvisibilitygrid')->__('Reindex'),
                        'url' => array(
                            'base' => '*/*/reindex'
                        ),
                        'field' => 'id'
                    )
                ),
                'filter' => false,
                'sortable' => false,
                'index' => 'stores'
            ));

        return parent::_prepareColumns();
    }

    /**
     * Prepares the grid mass action.
     *
     * @return Itonomy_ProductVisibilityGrid_Block_Adminhtml_Productvisibilitygrid_Product_Grid
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('product');

        $this->getMassactionBlock()->addItem('reindex', array(
            'label' => Mage::helper('productvisibilitygrid')->__('Reindex'),
            'url' => $this->getUrl('*/*/massReindex'),
        ));

        return $this;
    }

    /**
     * Returns the grid (ajax update) URL.
     *
     * @return string URL to request an update.
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current' => true));
    }

    /**
     * Returns a row URL.
     *
     * @param Varien_Object Row data.
     * @return string URL to product edit page.
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/catalog_product/edit', array(
                'store' => $this->getRequest()->getParam('store'),
                'id' => $row->getId()
            )
        );
    }

    /**
     * Applies the selected column filter to the collection.
     *
     * @param Mage_Adminhtml_Block_Widget_Grid_Column Column data.
     * @return Itonomy_ProductVisibilityGrid_Block_Adminhtml_Productvisibilitygrid_Product_Grid
     */
    protected function _addColumnFilterToCollection($column)
    {
        $value = $column->getFilter()->getValue();
        if (!isset($value)) {
            parent::_addColumnFilterToCollection($column);
            return $this;
        }

        switch ($column->getId()) {
            case 'in_flat_table':
                $this->getCollection()->addInFlatTableFilter((int)$value);
                break;
            case 'in_website':
                $this->getCollection()->addInWebsiteFilter((int)$value);
                break;
            case 'in_category':
                $this->getCollection()->addInCategoryFilter((int)$value);
                break;
            case 'in_stock':
                $this->getCollection()->addInStockFilter((int)$value);
                break;
            case 'in_price_index':
                $this->getCollection()->addInPriceIndexFilter((int)$value);
                break;
            default:
                parent::_addColumnFilterToCollection($column);
                break;
        }

        return $this;
    }
}

<?php

/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Adminhtml
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
/**
 * Catalog category controller
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */
include("Mage/Adminhtml/controllers/Catalog/CategoryController.php");

class Vishwasnature_Editableproduct_Adminhtml_Catalog_CategoryController extends Mage_Adminhtml_Catalog_CategoryController {

    public function editablegridAction() {
        if (!$category = $this->_initCategory(true)) {
            return;
        }
        $this->getResponse()->setBody(
                $this->getLayout()->createBlock('editableproduct/adminhtml_catalog_category_tab_editableproduct', 'category.editableproduct.grid')
                        ->toHtml()
        );
    }

    public function editproductAction() {
        if ($editableValue = $this->getRequest()->getParam('editable_value')) {
            try {
                $attrinfo = $this->getRequest()->getParam('attrinfo');
                Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
                $product = Mage::getModel('catalog/product')->load($this->getRequest()->getParam('id_info'));
                if ($product->getId()) {
                    if ($attrinfo == 'name') {
                        $product->setName($editableValue);
                    }
                    if ($attrinfo == 'sku') {
                        $product->setSku($editableValue);
                    }
                    if ($attrinfo == 'price') {
                        $product->setPrice($editableValue);
                    }
                    if ($attrinfo == 'special_price') {
                        $product->setSpecialPrice($editableValue);
                    }
                    if ($attrinfo == 'qty') {
                        $product->setStockData(array(
                       'qty' => $editableValue //qty
                        ));
                    }
                    if ($attrinfo == 'status') {
                        $product->setStatus($editableValue);
                    }
                    $product->save();
                    echo json_encode(array('status' => 'success', 'message' => 'Product has been updated'));
                }
            } catch (Exception $e) {
                Mage::log($e->getMessage());
                echo json_encode(array('status' => 'error','message'=> $e->getMessage()));
            }
        }
    }

}

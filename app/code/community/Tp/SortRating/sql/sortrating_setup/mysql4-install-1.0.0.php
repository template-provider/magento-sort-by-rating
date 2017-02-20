<?php
$installer = $this;

$installer->startSetup();

$productEntityTable = $installer->getTable('catalog/product');

/** @var Mage_Core_Model_Resource_Store_Collection $stores */
$stores = Mage::getResourceModel('core/store_collection');
foreach ($stores as $store) {
    $ratingSummaryStore = 'sort_rating_' . strtolower($store->getCode());
    $installer->getConnection()->addColumn($productEntityTable, $ratingSummaryStore, "INT DEFAULT NULL");
}
$installer->endSetup();

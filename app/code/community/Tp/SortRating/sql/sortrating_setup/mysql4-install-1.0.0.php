<?php
$installer = $this;

$installer->startSetup();

$productTable = $installer->getTable('catalog/product');
$reviewAggregate = $installer->getTable('review/review_aggregate');

/** @var Mage_Core_Model_Resource_Store_Collection $stores */
$stores = Mage::getResourceModel('core/store_collection');
foreach ($stores as $store) {
    $storeId = $store->getId();

    $ratingSummaryStore = 'sort_rating_' . strtolower($store->getCode());
    $installer->getConnection()->addColumn($productTable, $ratingSummaryStore, "INT DEFAULT NULL");

    $subQuery = "select AVG(rating_summary) as sort_rating, store_id, entity_pk_value
from {$reviewAggregate}
where reviews_count > 0
AND store_id = {$storeId}
group by entity_pk_value, store_id";

    $query = "Update {$productTable} as C
inner join ($subQuery) as A on C.entity_id = A.entity_pk_value
set C.{$ratingSummaryStore} = A.sort_rating";

    $installer->getConnection()->query($query);

}
$installer->endSetup();
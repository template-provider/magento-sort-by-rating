<?php

class Tp_SortRating_Model_Observer
{
    public function updateRating()
    {
        $resource = Mage::getSingleton('core/resource');
        $writeConnection = $resource->getConnection('core_write');
        $reviewAggregate = $resource->getTableName('review/review_aggregate');

        /** @var Mage_Core_Model_Store $stores */
        $stores = Mage::app()->getStores();
        foreach ($stores as $store) {
            $storeId = $store->getId();

            $productTable = $resource->getTableName('catalog/product');
            $ratingSummaryStore = 'sort_rating_' . strtolower($store->getCode());
            $writeConnection->addColumn($productTable, $ratingSummaryStore, "INT DEFAULT NULL");

            $subQuery = "select AVG(rating_summary) as sort_rating, store_id, entity_pk_value
from {$reviewAggregate}
where reviews_count > 0
AND store_id = {$storeId}
group by entity_pk_value, store_id";

            $query = "Update {$productTable} as C 
inner join ($subQuery) as A on C.entity_id = A.entity_pk_value 
set C.{$ratingSummaryStore} = A.sort_rating";
            Mage::log($query);

            $writeConnection->query($query);
        }

    }
}
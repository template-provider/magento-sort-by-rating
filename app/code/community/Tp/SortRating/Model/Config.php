<?php

class Tp_SortRating_Model_Config extends Mage_Catalog_Model_Config
{
    /**
     * @return array
     */
    public function getAttributeUsedForSortByArray()
    {
        return array_merge(
            parent::getAttributeUsedForSortByArray(),
            array('sort_rating' => Mage::helper('catalog')->__('Rating'))
        );
    }
}
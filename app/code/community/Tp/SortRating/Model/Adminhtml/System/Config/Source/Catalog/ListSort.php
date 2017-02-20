<?php

class Tp_SortRating_Model_Adminhtml_System_Config_Source_Catalog_ListSort extends Mage_Adminhtml_Model_System_Config_Source_Catalog_ListSort
{
    /**
     * Retrieve option values array
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options = parent::toOptionArray();
        $options[] = array(
            'label' => Mage::helper('catalog')->__('Rating'),
            'value' => 'sort_rating'
        );
        return $options;
    }
}

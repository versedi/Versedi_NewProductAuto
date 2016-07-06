<?php

/**
 * Class Versedi_NewProductAuto_Model_Observer
 * Automatically set product new from date on product creation and product new to date 3 months from that date.
 */
class Versedi_NewProductAuto_Model_Observer extends Mage_Core_Model_Abstract
{

    /**
     * @var string
     */
    protected $productNewFromDate;
    /**
     * @var string
     */
    protected $productNewToDate;

    /**
     *
     */
    public function _construct()
    {
        $now = date('d-m-Y', time());
        $this->productNewFromDate = $now;
        $this->productNewToDate = new \DateTime($now);
        $this->productNewToDate = $this->productNewToDate->add(new DateInterval('P3M'))->format('d-m-Y');
    }


    /**
     * @param Varien_Event_Observer $observer
     *
     */
    public function setProductNewFromDateToday(Varien_Event_Observer $observer)
    {
        $product = $observer->getEvent()->getProduct();
        if ($product->getOrigData() === NULL) { // Only if product is new - no original data exists
            $product->setNewsFromDate($this->productNewFromDate);
            $product->setNewsToDate($this->productNewToDate);
        }
    }
}
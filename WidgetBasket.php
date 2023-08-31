<?php
class WidgetBasket {
    private $productCatalogue;
    private $deliveryRules;
    private $offers;
    private $items = [];

    public function __construct($productCatalogue, $deliveryRules, $offers) {
        $this->productCatalogue = $productCatalogue;
        $this->deliveryRules = $deliveryRules;
        $this->offers = $offers;
    }

    public function add($productCode) {
        if (isset($this->productCatalogue[$productCode])) {
            $this->items[] = $productCode;
        }
    }

public function total() {
    $subtotal = 0;
    $redWidgetCount = array_count_values($this->items)['R01'] ?? 0; // Count red widgets
    
    foreach ($this->items as $item) {
        $subtotal += $this->productCatalogue[$item]['price'];
    }

    // Apply offers
    if ($redWidgetCount >= 2) {
        $redWidgetDiscount = floor($redWidgetCount / 2) * ($this->productCatalogue['R01']['price'] / 2);
        $subtotal -= $redWidgetDiscount;
    }

    // Apply delivery charge rules
    $totalCost = $subtotal;
    if ($totalCost < 50) {
        $totalCost += $this->deliveryRules['under50'];
    } elseif ($totalCost < 90) {
        $totalCost += $this->deliveryRules['under90'];
    } else {
        // Free delivery for orders of $90 or more
        $totalCost += 0;
    }

    return $totalCost;
}

}

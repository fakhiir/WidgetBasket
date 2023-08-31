<?php
require_once 'WidgetBasket.php'; // Include the class definition

// Define product catalogue, delivery rules, and offers
$productCatalogue = [
    'B01' => ['price' => 7.95],
    'G01' => ['price' => 24.95],
    'R01' => ['price' => 32.95],
];

$deliveryRules = [
    'under50' => 4.95,
    'under90' => 2.95,
];

$offers = [];

// Create a new WidgetBasket instance
$widgetBasket = new WidgetBasket($productCatalogue, $deliveryRules, $offers);

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productCodes = explode(',', $_POST['productCodes']);
    foreach ($productCodes as $productCode) {
        $productCode = trim($productCode);
        if (!empty($productCode)) {
            $widgetBasket->add($productCode);
        }
    }
}

// Calculate and display the total
$total = $widgetBasket->total();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Widget Basket Calculator - Result</title>
</head>
<body>
    <div class="container">
        <h1>Widget Basket Calculator - Result</h1>
        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
            <p>Total for products <?= implode(', ', $productCodes) ?>: $<?= number_format($total, 2) ?></p>
        <?php else: ?>
            <p>No products entered. Please go back and enter product codes.</p>
        <?php endif; ?>
        <a href="index.html">Go Back</a>
    </div>
</body>
</html>

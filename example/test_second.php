<?php

declare(strict_types=1);

use LireinCore\YMLParser\Category;
use LireinCore\YMLParser\Offer\AExtOffer;
use ShopManApi\Entity\OfferParams;
use ShopManApi\ShopManApi;

require __DIR__ . '/../vendor/autoload.php';

$handler = (new ShopManApi(42, '12demo89'))
    ->parseYml('dealby.yml');

/** @var DateTimeImmutable $date */
$date = $handler->getDate();
echo sprintf('Date: %s', $date->format('Y-m-d H:i:s')) . PHP_EOL;

/** @var Category[] $categories */
$categories = $handler->getCategories();
echo sprintf('Categories count: %d', count($categories)) . PHP_EOL;

/** @var AExtOffer[]|\Generator $offers */
$offers = $handler->getOffers();
if ($offers instanceof Generator) {
    $offers = iterator_to_array($offers);
}
/** @var \ShopManApi\YMLParser\Offer\ShopMVendorOffer $offer */
$offer = $offers[0];
$offerParams = new OfferParams($offer->getParams());

dump(get_class($offer));
dd($offer->getQuantityInStock());

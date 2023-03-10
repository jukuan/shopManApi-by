<?php

declare(strict_types=1);

namespace ShopManApi\YMLParser\Offer;

use LireinCore\YMLParser\Offer\VendorModelOffer;

class ShopMVendorOffer extends VendorModelOffer
{
    private int $quantityInStock = 0;

    public function addAttribute(array $attrNode): static
    {
        $name = $attrNode['name'] ?? '';

        if ('quantity_in_stock' === $name) {
            $this->quantityInStock = (int) ($attrNode['value'] ?? 0);
        } else {
            parent::addAttribute($attrNode);
        }

        return $this;
    }

    public function getQuantityInStock(): int
    {
        return $this->quantityInStock;
    }
}

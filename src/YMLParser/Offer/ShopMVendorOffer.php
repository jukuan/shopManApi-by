<?php

declare(strict_types=1);

namespace ShopManApi\YMLParser\Offer;

use LireinCore\YMLParser\Offer\VendorModelOffer;

class ShopMVendorOffer extends VendorModelOffer
{
    private int $quantityInStock = 0;
    private string $vendorName = '';

    public function addAttribute(array $attrNode): ShopMVendorOffer
    {
        $name = $attrNode['name'] ?? '';

        if ('quantity_in_stock' === $name) {
            $this->quantityInStock = (int) ($attrNode['value'] ?? 0);
        } else if ('vendor_name' === $name) {
            $this->vendorName = $attrNode['value'] ?? '';
        } else {
            parent::addAttribute($attrNode);
        }

        return $this;
    }

    public function getQuantityInStock(): int
    {
        return $this->quantityInStock;
    }

    public function getVendorName(): string
    {
        return $this->vendorName;
    }
}

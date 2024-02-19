<?php

declare(strict_types=1);

namespace ShopManApi\YMLParser\Offer;

use LireinCore\YMLParser\Offer\VendorModelOffer;

class ShopMVendorOffer extends VendorModelOffer
{
    private int $quantityInStock = 0;
    private string $vendorName = '';
    private string $importer = '';
    private string $serviceCenter = '';

    public function addAttribute(array $attrNode): ShopMVendorOffer
    {
        $name = $attrNode['name'] ?? '';

        if ('quantity_in_stock' === $name) {
            $this->quantityInStock = (int) ($attrNode['value'] ?? 0);
        } else if ('vendor_name' === $name) {
            $this->vendorName = $attrNode['value'] ?? '';
        } else if ('importer' === $name) {
            $attributes = $attrNode['attributes'] ?? [];
            $this->importer = $attributes ? reset($attributes) : '';
        } else if ('service_center' === $name) {
            $attributes = $attrNode['attributes'] ?? [];
            $this->serviceCenter = $attributes ? reset($attributes) : '';
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

    public function getImporter(): string
    {
        return $this->importer;
    }

    public function getServiceCenter(): string
    {
        return $this->serviceCenter;
    }
}

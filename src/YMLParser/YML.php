<?php

declare(strict_types=1);

namespace ShopManApi\YMLParser;

use LireinCore\YMLParser\Offer\ArtistTitleOffer;
use LireinCore\YMLParser\Offer\AudioBookOffer;
use LireinCore\YMLParser\Offer\BookOffer;
use LireinCore\YMLParser\Offer\EventTicketOffer;
use LireinCore\YMLParser\Offer\MedicineOffer;
use LireinCore\YMLParser\Offer\SimpleOffer;
use LireinCore\YMLParser\Offer\TourOffer;
use LireinCore\YMLParser\Offer\VendorModelOffer;
use LireinCore\YMLParser\YML as BaseYML;
use ShopManApi\YMLParser\Offer\ShopMVendorOffer;

class YML extends BaseYML
{
    /**
     * @param string $type
     */
    protected function createOffer($type): BookOffer|SimpleOffer|TourOffer|VendorModelOffer|ShopMVendorOffer|MedicineOffer|AudioBookOffer|ArtistTitleOffer|EventTicketOffer
    {
        if ('vendor.model' === $type) {
            return new ShopMVendorOffer();
        }

        return parent::createOffer($type);
    }
}

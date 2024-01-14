<?php

declare(strict_types=1);

namespace ShopManApi;

use DateTimeImmutable;
use Exception;
use Generator;
use LireinCore\YMLParser\Category;
use LireinCore\YMLParser\Offer\AExtOffer;
use LireinCore\YMLParser\Shop;
use Psr\Log\LoggerInterface;
use ShopManApi\YMLParser\Offer\ShopMVendorOffer;
use ShopManApi\YMLParser\YML;

class ShopManApi
{
    private const SM_API = 'https://api.shopmanager.by/d/api/';

    private ?LoggerInterface $logger = null;

    private ?YML $yml = null;

    private ?Exception $lastError = null;

    private int $shopId;
    private string $key;

    public function __construct(
        int $shopId,
        string $key
    ) {
        $this->shopId = $shopId;
        $this->key = $key;
    }

    public function reset(): ShopManApi
    {
        $this->yml = null;
        $this->lastError = null;

        return $this;
    }

    public function setLogger(?LoggerInterface $logger): ShopManApi
    {
        $this->logger = $logger;

        return $this;
    }

    public function getLastError(): ?Exception
    {
        return $this->lastError;
    }

    public function parseYml(string $file): ShopManApi
    {
        $url = self::SM_API . sprintf('%s?shopId=%d&key=%s', $file, $this->shopId, $this->key);

        $this->yml = new YML();

        try {
            $this->yml->parse($url);
        } catch (Exception $e) {
            $this->yml = null;
            $this->logException($e);
        }

        return $this;
    }

    public function getDate(): ?DateTimeImmutable
    {
        if (null === $this->yml) {
            return null;
        }

        $date = $this->yml->getDate() ?: null;

        if (null === $date) {
            return null;
        }

        try {
            return new DateTimeImmutable($date);
        } catch (Exception $e) {
            $this->logException($e);
        }

        return null;
    }

    public function getShop(): ?Shop
    {
        if ($this->yml) {
            $shop = $this->yml->getShop();
        } else {
            return null;
        }


        return $shop->isValid() ? $shop : null;
    }

    /**
     * @return AExtOffer[]|ShopMVendorOffer[]|Generator
     */
    public function getOffers()
    {
        if (null === $this->yml) {
            return [];
        }

        try {
            return $this->yml->getOffers() ?? [];
        } catch (Exception $e) {
            $this->logException($e);
        }
    }

    /**
     * @return Category[]
     */
    public function getCategories(): iterable
    {
        if ($this->getShop()) {
            $categories = $this->getShop()->getCategories();
        } else {
            return [];
        }

        return $categories ?? [];
    }

    private function logException(Exception $e): void
    {
        $this->lastError = $e;

        if (null === $this->logger) {
            return;
        }

        $message = sprintf('ShopApiHandler: %s', $e->getMessage());
        $this->logger->log('error', $message, [$e->getLine(), $e->getFile()]);
    }
}

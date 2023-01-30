<?php

declare(strict_types=1);

namespace ShopManApi\Entity;

use LireinCore\YMLParser\Offer\Param;

class OfferParams
{
    private array $paramsByName = [];

    public function __construct(array|null $params)
    {
        foreach ($params ?? [] as $param) {
            $this->paramsByName[$param->getName()] = $param;
        }
    }

    public function getParam(string $name): ?Param
    {
        return $this->paramsByName[$name] ?? null;
    }

    public function getParamValue(string $name, ?string $default = null): ?string
    {
        return $this->getParam($name)?->getValue() ?? $default;
    }
}

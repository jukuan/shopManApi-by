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

    public function getParamValueInt(string $name, ?int $default = null): ?int
    {
        $value = $this->getParamValue($name);

        return $value !== null ? (int) $value : $default;
    }

    public function getParamValueBool(string $name, ?bool $default = null): ?bool
    {
        $value = $this->getParamValue($name);

        if (null === $value) {
            return $default;
        }

        $value = mb_strtolower($value);

        return in_array($value, ['true', '1', 'да'], true);
    }
}

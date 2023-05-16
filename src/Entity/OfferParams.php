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
            if ($param instanceof Param) {
                $this->paramsByName[$param->getName()] = $param;
            }
        }
    }

    public function getParam(string $name): ?Param
    {
        return $this->paramsByName[$name] ?? null;
    }

    public function getParamValue(string $name, ?string $default = null): ?string
    {
        $value = $this->getParam($name)?->getValue() ?? null;

        if (null !== $value && !is_string($value)) {
            $value = (string)$value;
        }

        return $value ?? $default;
    }

    public function getParamValueInt(string $name, ?int $default = null): ?int
    {
        $value = $this->getParam($name)?->getValue() ?? null;

        return null !== $value ? (int) $value : $default;
    }

    public function getParamValueBool(string $name, ?bool $default = null): ?bool
    {
        $value = $this->getParam($name)?->getValue() ?? null;

        if (null === $value) {
            return $default;
        }

        if (is_bool($value)) {
            return $value;
        }

        $value = mb_strtolower($value);

        if (in_array($value, ['', 'false', '0', 'нет', 'no'], true)) {
            return false;
        }

        if (in_array($value, ['true', '1', 'да', 'yes'], true)) {
            return true;
        }

        return $default;
    }
}

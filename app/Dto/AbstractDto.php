<?php


namespace App\Dto;

use JsonSerializable;

abstract class AbstractDto implements JsonSerializable
{
    public function __construct(array $data)
    {
        foreach ($data as $property => $value) {
            $camelProperty = $this->toCamel($property);

            if (property_exists($this, $camelProperty)) {
                $this->$camelProperty = $value;
            }
        }
    }

    private function toCamel(string $string): string
    {
        return lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $string))));
    }

    private function toUnderscoreCase(string $string): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $string));
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }

    public function jsonSerialize(): array
    {
        $vars = $this->toArray();
        $result = [];

        foreach ($vars as $key => $value) {
            $key = $this->toUnderscoreCase($key);
            $result[$key] = $value;
        }

        return $result;
    }
}

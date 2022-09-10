<?php


namespace App\Dto;

class DtoFactory
{
    public function createDto(string $dtoClass, array $data): AbstractDto
    {
        return new $dtoClass($data);
    }
}

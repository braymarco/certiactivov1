<?php

namespace App\ExternalServices\Identidata\DTO;

class PersonData
{
    public string $identificacion;
    public string $fullName;
    public ?string $name;
    public ?string $firstSurname;
    public ?string $secondSurname;
    public ?string $tradeName;
    public int $localOrdered;
    public ?string $email;
    public ?string $address;
    public ?string $birthdate;
    public int $fullNameOrder;

    public function __construct(array $data)
    {
        $this->identificacion  = $data['identificacion'];
        $this->fullName        = $data['full_name'];
        $this->name            = $data['name'];
        $this->firstSurname    = $data['first_surname'];
        $this->secondSurname   = $data['second_surname'];
        $this->tradeName       = $data['trade_name'] ?? null;
        $this->localOrdered    = (int) $data['local_ordered'];
        $this->email           = $data['email'] ?? null;
        $this->address         = $data['address'] ?? null;
        $this->birthdate       = $data['birthdate'] ?? null;
        $this->fullNameOrder   = (int) $data['full_name_order'];
    }

    /**
     * Crear instancia desde respuesta completa del API
     */
    public static function fromApiResponse(array $response): ?self
    {
        if (($response['status'] ?? null) !== 'success') {
            return null;
        }

        return new self($response['data']);
    }

    /**
     * Convertir nuevamente a array (útil para logs o guardar)
     */
    public function toArray(): array
    {
        return [
            'identificacion'   => $this->identificacion,
            'full_name'        => $this->fullName,
            'name'             => $this->name,
            'first_surname'    => $this->firstSurname,
            'second_surname'   => $this->secondSurname,
            'trade_name'       => $this->tradeName,
            'local_ordered'    => $this->localOrdered,
            'email'            => $this->email,
            'address'          => $this->address,
            'birthdate'        => $this->birthdate,
            'full_name_order'  => $this->fullNameOrder,
        ];
    }

    /**
     * Nombre completo formateado según el orden indicado
     */
    public function getFormattedFullName(): string
    {
        return $this->fullNameOrder === 1
            ? "{$this->firstSurname} {$this->secondSurname} {$this->name}"
            : "{$this->name} {$this->firstSurname} {$this->secondSurname}";
    }
}
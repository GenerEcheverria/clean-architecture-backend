<?php
namespace Core\UseCases;

use Core\Entities\ClientDTO;
use Core\Interfaces\ClientStore;
use Illuminate\Support\Facades\Validator;

class RegisterClient
{
    private $clientStore;

    public function __construct(ClientStore $clientStore)
    {
        $this->clientStore = $clientStore;
    }

    public function execute(array $clientData): ClientDTO
    {
        $validator = Validator::make($clientData, [
            'name' => 'required',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|string',
            'phone' => 'required',
        ]);

        // Manejar errores de validación
        if ($validator->fails()) {
            // Aquí podrías arrojar una excepción o manejar el error de otra manera
            // Por ejemplo, podrías definir una excepción personalizada y lanzarla.
            throw new \InvalidArgumentException($validator->errors()->toJson());
        }
        $encryptedPassword = bcrypt($clientData['password']);
        $client = new ClientDTO(
            $clientData['name'],
            $clientData['email'],
            $encryptedPassword,
            $clientData['role'],
            $clientData['phone']
        );
        $this->clientStore->save($client);

        return $client;
    }
}

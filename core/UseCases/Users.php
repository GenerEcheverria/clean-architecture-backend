<?php

namespace Core\UseCases;

use Core\Entities\UserDTO;
use Core\Interfaces\UserStore;

class Users
{
    private $userStore;

    public function __construct(UserStore $userStore)
    {
        $this->userStore = $userStore;
    }

    public function getAll()
    {
        return $this->userStore->getAll();
    }

    public function register(array $userData): UserDTO
    {
        $encryptedPassword = bcrypt($userData['password']);
        $user = new UserDTO(
            $userData['name'],
            $userData['email'],
            $encryptedPassword,
            $userData['role'],
            $userData['phone']
        );
        $this->userStore->save($user);

        return $user;
    }

    public function getById($id)
    {
        return $this->userStore->getById($id);
    }

    public function update(array $userData, $id)
    {
        $user = $this->userStore->getById($id);
        if (isset($userData["client"]["name"])) {
            $user->name =  $userData["client"]["name"];
            $user->email =  $userData["client"]["email"];
            $user->phone =  $userData["client"]["phone"];
        }
        if (isset($userData["client"]["newPassword"])) {
            $user->password = bcrypt($userData["client"]["newPassword"]);
        }
        $userDTO = new UserDTO(
            $user->name,
            $user->email,
            $user->password,
            $user->role,
            $user->phone
        );
        $this->userStore->update($userDTO, $id);
    }

    public function delete($id): bool{
        return $this->userStore->delete($id);
    }
}

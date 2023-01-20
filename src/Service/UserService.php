<?php

namespace App\Service;

use App\Repository\UserRepository;

class UserService
{

    private $userRepository;
    public function __construct(UserRepository $userRepository){
        $this->userRepository = $userRepository;
    }

    public function getMedecinChef(){
        return $this->userRepository->findOneByMedecinChef();
    }
}
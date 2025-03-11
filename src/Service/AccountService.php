<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Account as EntityAccount;
use App\Repository\AccountRepository;
use Exception;

class AccountService{

    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly AccountRepository $accountRepository
    ) {

    }

    public function save(EntityAccount $account) {
        //Tester si les champs sont tous remplis
        if($account->getFirstname() !="" && $account->getLastname() !="" && $account->getEmail() !="" && $account->getPassword() !="") {
            //Teste si le compte n'existe pas
            if($this->accountRepository->findOneBy(["email"=>$account->getEmail()])) {
                //Setter les paramètres
                $account->setRoles("ROLE_USER");
                $this->em->persist($account);
                $this->em->flush();
            }
            else {
                throw new \Exception("Le compte existe déjà", 400);
            }
        }
        //Si les champs ne sont pas remplis
        else {
            throw new \Exception("Les champs ne sont pas tous remplis", 400);
        }
    }

    public function getAll() {
        $accounts = $this->accountRepository->findAll();
        if($accounts) {
            return $accounts;
        }
        else {
            throw new \Exception("La liste est vide", 400);
        }
    }

    public function getById(int $id) {
        $account = $this->accountRepository->findOneBy(["id" => $id]);
        if($account) {
            return $account;
        }
        else {
            throw new \Exception("Aucun compte correspondant trouvé", 400);
        }
    }
}
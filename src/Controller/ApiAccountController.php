<?php

namespace App\Controller;

use App\Entity\Account;
use App\Repository\AccountRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Serializer\SerializerInterface;

final class ApiAccountController extends AbstractController
{

    public function __construct(
        private readonly AccountRepository $accountRepository,
        private readonly EntityManagerInterface $em,
        private readonly SerializerInterface $serializer
    ){}

    #[Route('/api/accounts', name: 'api_account_all')]
    public function getAllAccounts(): Response
    {
        return $this->json(
            $this->accountRepository->findAll(),
            200,
            [],
            ['groups'=>'account:read']
        );
    }

    #[Route('/api/account', name: 'app_account_add', methods: ['POST'])]
    public function addAccount(Request $request, UserPasswordHasherInterface $hasher): Response
    {
        //Récupération le body de la requête
        $request = $request->getContent();
        //Convertir en objet Account
        $account = $this->serializer->deserialize($request, Account::class, 'json');
        //Tester si le compte n'existe pas
        if($account->getFirstName() && $account->getLastName() && $account->getEmail() && $account->getPassword() && $account->getRoles()) {
            $account->setPassword($hasher->hashPassword($account, $account->getPassword()));
            if (!$this->accountRepository->findOneBy(["email" => $account->getEmail()])) {
                $this->em->persist($account);
                $this->em->flush();
                $code = 201;
            }
            //S'il existe déjà
            else {
                $account = "Le compte existe déjà";
                $code = 400;
            }
        }
        //Si les champs ne sont pas remplis
        else {
            $account = "Veuillez remplir tous les champs";
            $code = 400;
        }
        
        return $this->json($account, $code, [
            "Access-Control-Allow-Origin" => $this->getParameter('allowed_origin')
        ], ["groups" => "account:create"]);
    }

    #[Route('/api/account/update', name: 'app_account_update', methods: ['PUT'])]
    public function updateAccount(Request $request): Response
    {
        // Récupération du body de la requête
        $request = $request->getContent();
        // Conversion en objet Account
        $account = $this->serializer->deserialize($request, Account::class, 'json');
        
        // Vérification si le compte existe
        $existingAccount = $this->accountRepository->findOneBy(["email" => $account->getEmail()]);
        
        if (!$existingAccount) {
            $account = "Le compte n'existe pas";
            $code = 400;
        }
        // Si le compte existe
        elseif ($account->getFirstName() && $account->getLastName() && $account->getEmail() && $account->getPassword() && $account->getRoles()) {
            $existingAccount->setFirstname($account->getFirstname());
            $existingAccount->setLastname($account->getLastname());
            $this->em->flush();
            $code = 202;
            $account = $existingAccount;
        }
        // Si les champs ne sont pas remplis
        else {
            $account = "Veuillez remplir tous les champs";
            $code = 400;
        }
    
        return $this->json($account, $code, [
            "Access-Control-Allow-Origin" => $this->getParameter('allowed_origin')
        ], ["groups" => "account:update"]);
    }

    #[Route('/api/account/delete', name: 'app_account_delete', methods: ['DELETE'])]
    public function deleteAccount(Request $request): Response
    {
        // Récupération du body de la requête
        $request = $request->getContent();
        // Conversion en objet Account
        $account = $this->serializer->deserialize($request, Account::class, 'json');
        
        // Vérification si le compte existe
        if (!$this->accountRepository->findOneBy(["id" => $account->getId()])) {
            $account = "Le compte n'existe pas";
            $code = 400;
        }
        // Si le compte existe
        else {
            $this->em->remove($account);
            $this->em->flush();
            $account = "Le compte a été supprimé avec succès";
            $code = 202;
        }
    
        return $this->json($account, $code, [
            "Access-Control-Allow-Origin" => $this->getParameter('allowed_origin')
        ], ["groups" => "account:delete"]);
    }

    #[Route('/api/account/changepswd', name: 'app_account_pswd', methods: ['PATCH'])]
    public function changePassword(Request $request, UserPasswordHasherInterface $hasher): Response
    {
        // Récupération du body de la requête
        $request = $request->getContent();
        // Conversion en objet Account
        $account = $this->serializer->deserialize($request, Account::class, 'json');
        
        // Vérification si le compte existe
        $existingAccount = $this->accountRepository->findOneBy(["email" => $account->getEmail()]);
        
        if (!$existingAccount) {
            $account = "Le compte n'existe pas";
            $code = 400;
        }
        // Si le mot de passe n'est pas fourni dans la requête
        elseif (!$account->getPassword()) {
            $account = "Mot de passe non fourni";
            $code = 400;
        }
        else {
            // Mise à jour du mot de passe
            $existingAccount->setPassword($hasher->hashPassword($existingAccount, $account->getPassword()));
            $this->em->flush();
            $code = 202;
            $account = "Mot de passe mis à jour avec succès";
        }
    
        return $this->json($account, $code, [
            "Access-Control-Allow-Origin" => $this->getParameter('allowed_origin')
        ], ["groups" => "account:patch"]);
    }
}

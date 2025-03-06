<?php

namespace App\Controller;

use App\Entity\Account;
use App\Repository\AccountRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ApiAccountController extends AbstractController
{

    public function __construct(
        private readonly AccountRepository $accountRepository
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
}

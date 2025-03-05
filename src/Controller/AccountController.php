<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\AccountRepository;

final class AccountController extends AbstractController
{

    public function __construct(
        private readonly AccountRepository $accountRepository
    ){}

    #[Route('/account', name: 'app_account')]
    public function showAllAccounts(): Response
    {
        

        return $this->render('account/accounts.html.twig', [
            'accounts' => $this->accountRepository->findAll(),
        ]);
    }
}

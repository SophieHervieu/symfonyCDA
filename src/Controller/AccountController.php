<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\AccountRepository;
use App\Form\AccountType;
use App\Entity\Account;
use App\Service\AccountService;

final class AccountController extends AbstractController
{

    public function __construct(
        private readonly AccountRepository $accountRepository,
        private readonly AccountService $accountService
    ){}

    #[Route('/account', name: 'app_account')]
    public function showAllAccounts(): Response
    {
        $msg = "";
        $status = "";

        try {
            $this->accountService->getAll();
            $status = "success";
            $msg ="La liste des comptes a bien été récupérée";
        }
        catch(\Exception $e) {
            $status = "danger";
            $msg =$e->getMessage();
        }

        $this->addFlash($status, $msg);

        return $this->render('account/accounts.html.twig', [
            'accounts' => $this->accountService->getAll(),
        ]);
    }

    #[Route('/account/{id}', name: 'app_account_id')]
    public function showById(int $id): Response
    {
        $msg = "";
        $status = "";

        try {
            $account = $this->accountService->getById($id);
            $status = "success";
            $msg ="La liste des comptes a bien été récupérée";
        }
        catch(\Exception $e) {
            $status = "danger";
            $msg =$e->getMessage();
        }

        $this->addFlash($status, $msg);

        return $this->render('account/oneAccount.html.twig', [
            'account' => $account??null,
        ]);
    }

    #[Route('/account/add', name:'app_account_add')]
    public function addAccount(Request $request): Response
    {   
        
        $account = new Account();
        $form = $this->createForm(AccountType::class, $account);
        $form->handleRequest($request);
        $msg = "";
        $status ="";
        if($form->isSubmitted() && $form->isValid()){
            try {
                //Appel de la méthode save d'accountService
                $this->accountService->save($account);
                $status = "success";
                $msg = "Le compte a bien été ajouté en BDD";
            }
            //Capturer les exceptions (erreurs)
            catch (\Exception $e) {
                $status = "danger";
                $msg =$e->getMessage();
            }

            $this->addFlash($status, $msg);
        }
        return $this->render('account/addaccount.html.twig',
        [
            'form'=> $form
        ]);
    }
}

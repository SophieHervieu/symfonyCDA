<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CalculatriceController extends AbstractController
{
    #[Route(path:'/calculatrice/{num1}/{num2}/{operator}', name: 'app_calculatrice')]
    public function calculate(int $num1, int $num2, string $operator): Response
    {
        $result = null;

        switch($operator){
            case "addition":
                $result = $num1 + $num2;
                break;
            case "soustraction":
                $result = $num1 - $num2;
                break;
            case "multiplication":
                $result = $num1 * $num2;
                break;
            case "division":
                $result = ($num2 != 0) ? $num1 / $num2 : "Division par zéro impossible";
                break;
            default:
                $result = "NaN";
                break;
        }
        return $this->render('calculatrice/calculate.html.twig', [
            'num1' => $num1,
            'num2' => $num2,
            'operator' => $operator,
            'result' => $result
        ]);
    }
}

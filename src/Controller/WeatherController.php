<?php

namespace App\Controller;

use App\Service\WeatherService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class WeatherController extends AbstractController
{
    #[Route('/weather', name: 'app_weather')]
    public function showWeather(WeatherService $weatherService): Response
    {
        $weather = $weatherService->getWeather();
        return $this->render('weather/weather.html.twig', [
            'weather' => $weather,
        ]);
    }
}

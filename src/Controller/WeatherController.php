<?php

namespace App\Controller;

use App\Entity\Location;
use App\Repository\LocationRepository;
use App\Repository\MeasurementRepository;
use App\Service\WeatherUtil;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class WeatherController extends AbstractController
{
    #[Route('/weather/{country}/{city}', name: 'app_weather')]
    public function city(
        string $country,
        string $city,
        LocationRepository $locationRepository,
        WeatherUtil $weatherUtil
    ): Response
    {
        $location = $locationRepository->findByCountryAndCity($country, $city);

        if (!$location) {
            throw $this->createNotFoundException('Location not found.');
        }

        $measurements = $weatherUtil->getWeatherForLocation($location);

        return $this->render('weather/city.html.twig', [
            'location' => $location,
            'measurements' => $measurements,
        ]);
    }
}

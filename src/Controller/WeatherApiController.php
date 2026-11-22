<?php

namespace App\Controller;

use App\Entity\Measurement;
use App\Service\WeatherUtil;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;

final class WeatherApiController extends AbstractController
{
    #[Route('/api/v1/weather', name: 'app_weather_api')]
    public function index(
        #[MapQueryParameter] string $city,
        #[MapQueryParameter] string $country,
        WeatherUtil $weatherUtil,
        #[MapQueryParameter] string $format = 'json',
        #[MapQueryParameter('twig')] bool $twig = false
    ): Response
    {
        if (!in_array($format, ['json', 'csv'], true)) {
            return new Response(
                'Unsupported format. Available formats: json, csv.',
                400
            );
        }

        $measurements = $weatherUtil->getWeatherForCountryAndCity($country, $city);

        if ($twig) {
            $template = $format === 'csv'
                ? 'weather_api/index.csv.twig'
                : 'weather_api/index.json.twig';

            $contentType = $format === 'csv'
                ? 'text/plain; charset=UTF-8'
                : 'application/json; charset=UTF-8';

            return $this->render($template, [
                'city' => $city,
                'country' => $country,
                'measurements' => $measurements,
            ], new Response(null, 200, ['Content-Type' => $contentType]));
        }

        if ($format === 'csv') {
            $lines = ['city,country,date,celsius,fahrenheit,precipitation,humidity,wind'];

            foreach ($measurements as $m) {
                $lines[] = sprintf(
                    '%s,%s,%s,%s,%s,%s,%s,%s',
                    $city,
                    $country,
                    $m->getDate()->format('Y-m-d'),
                    $m->getTemperature(),
                    $m->getTemperatureInFahrenheit(),
                    $m->getPrecipitation(),
                    $m->getHumidity(),
                    $m->getWind()
                );
            }

            return new Response(
                implode("\r\n", $lines) . "\r\n",
                200,
                ['Content-Type' => 'text/plain; charset=UTF-8']
            );
        }

        return $this->json([
            'city' => $city,
            'country' => $country,
            'measurements' => array_map(fn(Measurement $m) => [
                'date' => $m->getDate()->format('Y-m-d'),
                'celsius' => $m->getTemperature(),
                'fahrenheit' => $m->getTemperatureInFahrenheit(),
                'precipitation' => $m->getPrecipitation(),
                'humidity' => $m->getHumidity(),
                'wind' => $m->getWind()
            ], $measurements)
        ]);
    }
}

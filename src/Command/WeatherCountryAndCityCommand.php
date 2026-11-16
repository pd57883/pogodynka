<?php

namespace App\Command;

use App\Service\WeatherUtil;
use Symfony\Component\Console\Attribute\Argument;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'weather:country-and-city',
    description: 'Displays weather forecast for a given country code and city name',
)]
class WeatherCountryAndCityCommand
{
    public function __construct(
        private WeatherUtil $weatherUtil,
    ) {
    }

    public function __invoke(
        SymfonyStyle $io,
        #[Argument('Country')] string $country,
        #[Argument('City')] string $city,
    ): int {
        $measurements = $this->weatherUtil->getWeatherForCountryAndCity($country, $city);

        $io->writeln(sprintf('Location: %s (%s)', $city, $country));
        $io->table(['Date', 'Temperature', 'Precipitation', 'Humidity', 'Wind'], array_map(fn($m) => [
            $m->getDate()->format('Y-m-d'),
            $m->getTemperature(),
            $m->getPrecipitation(),
            $m->getHumidity(),
            $m->getWind(),
        ], $measurements));

        return Command::SUCCESS;
    }
}

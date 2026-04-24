<?php

require_once 'Car.php';
require_once 'CarFactory.php';
require_once 'EngineTypeEnum.php';

echo "------------------------\n";
echo "Quantum Car Application\n";
echo "-----------------------\n";

// Create a car with an electric engine
$car = CarFactory::createCar(EngineTypeEnum::ELECTRIC);
$car->start(); // speed = 0
$car->setSpeed(60);
echo "Current speed: " . $car->getSpeed() . " km/h\n";
$car->accelerate(); // speed = 80
echo "Current speed after acceleration: " . $car->getSpeed() . " km/h\n";
$car->brake(); // speed = 60
$car->brake(); // speed = 40
$car->brake(); // speed = 20
$car->brake(); // speed = 0
echo "Current speed after braking: " . $car->getSpeed() . " km/h\n";
$car->stop(); // speed = 0

echo "\n";

// Create a car with an gas engine
$car = CarFactory::createCar(EngineTypeEnum::GAS);
$car->start(); // speed = 0
$car->setSpeed(60);
echo "Current speed: " . $car->getSpeed() . " km/h\n";
$car->accelerate(); // speed = 80
echo "Current speed after acceleration: " . $car->getSpeed() . " km/h\n";
$car->brake(); // speed = 60
$car->brake(); // speed = 40
$car->brake(); // speed = 20 - cannot brake while moving
// $car->brake(); // speed = 0 
echo "Current speed after braking: " . $car->getSpeed() . " km/h\n";
$car->stop(); // speed = 0

echo "\n";


// Create a car with an hybrid engine
$car = CarFactory::createCar(EngineTypeEnum::HYBRID);
$car->start(); // speed = 0
$car->setSpeed(35); // still with the electric engine, no gas yet
echo "Current speed: " . $car->getSpeed() . " km/h\n";
$car->accelerate(); // speed = 55 - gas now, no electric
echo "Current speed after acceleration: " . $car->getSpeed() . " km/h\n";
$car->brake(); // speed = 35
echo "Current speed after braking: " . $car->getSpeed() . " km/h\n";

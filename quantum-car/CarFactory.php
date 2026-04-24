<?php

require_once 'ElectricEngine.php';
require_once 'GasEngine.php';
require_once 'HybridEngine.php';

class CarFactory
{
    public static function createCar(EngineTypeEnum $engineType): Car
    {
        // Building the Car and Engine objects and wiring them together
        $car = new Car();

        switch ($engineType) {
            case EngineTypeEnum::ELECTRIC:
                $car->setEngine(new ElectricEngine());
                break;
            case EngineTypeEnum::GAS:
                $car->setEngine(new GasEngine());
                break;
            case EngineTypeEnum::HYBRID:
                $car->setEngine(new HybridEngine());
                break;
            default:
                throw new InvalidArgumentException("Invalid engine type, please provide one of the following: " . implode(", ", EngineTypeEnum::values()));
        }

        return $car;
    }       
}
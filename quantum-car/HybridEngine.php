<?php

class HybridEngine implements Engine
{
    private int $speed;
    private ElectricEngine $electricEngine;
    private GasEngine $gasEngine;
    private $workingEngine;

    public function start(): void
    {
        $this->gasEngine = new GasEngine();
        $this->electricEngine = new ElectricEngine();
        $this->workingEngine = $this->electricEngine;
        $this->workingEngine->start();
    }

    public function stop(): void
    {
        $this->workingEngine->stop();
    }

    public function setSpeed(int $speed): void
    {
        $this->engineSwitch($speed);

        $this->speed = $speed;
    }

    public function getSpeed(): int
    {
        return $this->speed;
    }

    public function increase(int $amount): int
    {
        return $this->speed += $amount;
    }

    public function decrease(int $amount): int
    {
        return $this->speed -= $amount;
    }

    private function engineSwitch($speed): void
    {
        // not to run both engines at the same time
        if ($speed < 50) {
            $this->workingEngine = $this->electricEngine;
            $this->workingEngine->start();
            $this->gasEngine->stop();
        } else {
            $this->workingEngine = $this->gasEngine;
            $this->workingEngine->start();
            $this->electricEngine->stop();
        }
    }
}
<?php

require_once 'Engine.php';

class ElectricEngine implements Engine
{
    private int $speed;

    public function start(): void
    {
        $this->speed = 0;
        echo "Electric engine started.\n";
    }

    public function stop(): void
    {
        if ($this->speed === 0) {
            echo "Electric engine stopped.\n";
        } else {
            echo "Cannot stop electric engine while it's moving.\n";
        }
    }

    public function setSpeed(int $speed): void
    {
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
}
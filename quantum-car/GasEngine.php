<?php

class GasEngine implements Engine
{
    private int $speed = 0;
    
    public function start(): void
    {
        $this->speed = 0;
        echo "Gas engine started.\n";
    }

    public function stop(): void
    {
        if ($this->speed === 0) {
            echo "Gas engine stopped.\n";
        } else {
            echo "Cannot stop gas engine while it's moving.\n";
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
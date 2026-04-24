<?php

class Car
{
    private Engine $engine;

    public function setEngine(Engine $engine): void
    {
        $this->engine = $engine;
    }

    public function start(): void
    {
        $this->engine->start();
    }

    public function stop(): void
    {
        $this->engine->stop();
    }

    public function setSpeed(int $speed): void
    {
        $this->engine->setSpeed($speed);
    }

    public function getSpeed(): int
    {
        return $this->engine->getSpeed();
    }

    public function accelerate(): void
    {
        $speed = $this->engine->getSpeed();
        if ($speed < 200) {
            $this->engine->setSpeed($speed += 20);
        }
    }

    public function brake(): void
    {
        $speed = $this->engine->getSpeed();
        if ($speed >= 20) {
            $this->engine->setSpeed($speed -= 20);
        } else {
            $speed = $this->engine->decrease(1);
            $this->engine->setSpeed($speed);
        }
    }
}
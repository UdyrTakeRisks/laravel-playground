<?php

interface Engine
{
    public function start(): void;
    public function stop(): void;
    public function setSpeed(int $speed): void;

    public function getSpeed(): int;

    public function increase(int $amount): int;
    public function decrease(int $amount): int;
}
<?php

declare(strict_types=1);

namespace Example;

use DateTimeImmutable;
use LogicException;

class GraphedData
{
    private int $startX;
    private int $startY;
    private int $startZ;

    private ?int $endX;
    private ?int $endY;
    private ?int $endZ;

    private int $colorR;
    private int $colorG;
    private int $colorB;
    private int $colorA;
    private int $weight;

    private ?string $label;

    private DateTimeImmutable $createdAt;
    private int $createdByUserId;

    public function __construct(int $startX, int $startY, int $startZ, ?int $endX, ?int $endY, ?int $endZ, int $colorR, int $colorG, int $colorB, int $colorA, int $weight, ?string $label, DateTimeImmutable $createdAt, int $createdByUserId)
    {
        if ($endX === null || $endY === null || $endZ === null) {
            if ($endX !== null || $endY !== null || $endZ !== null) {
                throw new LogicException('Either all endpoint values must be set or none must be set');
            }
        }

        if ($colorR > 255 || $colorR < 0) {
            throw new LogicException('Red color value must be between 0 and 255 inclusive');
        }

        if ($colorG > 255 || $colorG < 0) {
            throw new LogicException('Green color value must be between 0 and 255 inclusive');
        }

        if ($colorB > 255 || $colorB < 0) {
            throw new LogicException('Blue color value must be between 0 and 255 inclusive');
        }

        if ($colorA > 100 || $colorA < 0) {
            throw new LogicException('Alpha color value must be between 0 and 100 inclusive');
        }

        $this->startX = $startX;
        $this->startY = $startY;
        $this->startZ = $startZ;
        $this->endX = $endX;
        $this->endY = $endY;
        $this->endZ = $endZ;
        $this->colorR = $colorR;
        $this->colorG = $colorG;
        $this->colorB = $colorB;
        $this->colorA = $colorA;
        $this->weight = $weight;
        $this->label = $label;
        $this->createdAt = $createdAt;
        $this->createdByUserId = $createdByUserId;
    }

    public function getStartX(): int
    {
        return $this->startX;
    }

    public function getStartY(): int
    {
        return $this->startY;
    }

    public function getStartZ(): int
    {
        return $this->startZ;
    }

    public function getEndX(): ?int
    {
        return $this->endX;
    }

    public function getEndY(): ?int
    {
        return $this->endY;
    }

    public function getEndZ(): ?int
    {
        return $this->endZ;
    }

    public function getColorR(): int
    {
        return $this->colorR;
    }

    public function getColorG(): int
    {
        return $this->colorG;
    }

    public function getColorB(): int
    {
        return $this->colorB;
    }

    public function getColorA(): int
    {
        return $this->colorA;
    }

    public function getWeight(): int
    {
        return $this->weight;
    }

    public function isLabeled(): bool
    {
        return $this->label !== null;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getCreatedByUserId(): int
    {
        return $this->createdByUserId;
    }

    public function isPoint(): bool
    {
        return $this->endX === null;
    }

    public function isLine(): bool
    {
        return $this->endX !== null;
    }
}

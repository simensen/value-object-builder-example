<?php

declare(strict_types=1);

namespace Example;

use DateTimeImmutable;
use LogicException;

class GraphedDataBuilder
{
    const DEFAULT_COLOR_R = 255;
    const DEFAULT_COLOR_G = 255;
    const DEFAULT_COLOR_B = 255;
    const DEFAULT_COLOR_A = 100;

    const DEFAULT_WEIGHT = 5;

    private int $startX;
    private int $startY;
    private int $startZ;

    private ?int $endX;
    private ?int $endY;
    private ?int $endZ;

    private int $colorR = self::DEFAULT_COLOR_R;
    private int $colorG = self::DEFAULT_COLOR_G;
    private int $colorB = self::DEFAULT_COLOR_B;
    private int $colorA = self::DEFAULT_COLOR_A;
    private int $weight = self::DEFAULT_WEIGHT;

    private ?string $label;

    private DateTimeImmutable $createdAt;
    private int $createdByUserId;

    static public function new(): self
    {
        return new static();
    }

    public function pointAt($x, $y, $z): self
    {
        $instance = clone($this);

        $instance->startX = $x;
        $instance->startY = $y;
        $instance->startZ = $z;

        $instance->endX = null;
        $instance->endY = null;
        $instance->endZ = null;

        return $instance;
    }

    public function lineBetween(int $startX, int $startY, int $startZ, int $endX, int $endY, int $endZ): self
    {
        return $this->lineFrom($startX, $startY, $startZ)->lineTo($endX, $endY, $endZ);
    }

    public function lineFrom($x, $y, $z): self
    {
        $instance = clone($this);

        $instance->startX = $x;
        $instance->startY = $y;
        $instance->startZ = $z;

        return $instance;
    }

    public function lineTo($x, $y, $z): self
    {
        $instance = clone($this);

        $instance->endX = $x;
        $instance->endY = $y;
        $instance->endZ = $z;

        return $instance;
    }

    public function withLabel(string $label): self
    {
        $instance = clone($this);

        $instance->label = $label;

        return $instance;
    }

    public function withoutLabel(): self
    {
        $instance = clone($this);

        $instance->label = null;

        return $instance;
    }

    public function withCreatedByUserId(int $createdByUserId): self
    {
        $instance = clone($this);

        $instance->createdByUserId = $createdByUserId;

        return $instance;
    }

    public function withCreatedAt(DateTimeImmutable $createdAt): self
    {
        $instance = clone($this);

        $instance->createdAt = $createdAt;

        return $instance;
    }

    public function withRgb(int $colorR, int $colorG, int $colorB): self
    {
        $instance = clone($this);

        $instance->colorR = $colorR;
        $instance->colorG = $colorG;
        $instance->colorB = $colorB;

        return $instance;
    }

    public function withRgba(int $colorR, int $colorG, int $colorB, int $colorA): self
    {
        $instance = clone($this);

        $instance->colorR = $colorR;
        $instance->colorG = $colorG;
        $instance->colorB = $colorB;
        $instance->colorA = $colorA;

        return $instance;
    }

    public function withAlpha(int $alpha): self
    {
        $instance = clone($this);

        $instance->colorA = $alpha;

        return $instance;
    }

    public function build(): GraphedData
    {
        if (! isset($this->startX, $this->startY, $this->startZ)) {
            throw new LogicException('The starting point was not specified');
        }

        if (! isset($this->createdByUserId)) {
            throw new LogicException('The created by user ID was not specified');
        }

        $startX = $this->startX;
        $startY = $this->startY;
        $startZ = $this->startZ;

        $endX = $this->endX;
        $endY = $this->endY;
        $endZ = $this->endZ;

        $colorR = $this->colorR;
        $colorG = $this->colorG;
        $colorB = $this->colorB;
        $colorA = $this->colorA;

        $weight = $this->weight;
        $label = $this->label ?? null;

        $createdAt = $this->createdAt ?? new DateTimeImmutable('now');
        $createdByUserId = $this->createdByUserId;

        return new GraphedData(
            $startX,
            $startY,
            $startZ,
            $endX,
            $endY,
            $endZ,
            $colorR,
            $colorG,
            $colorB,
            $colorA,
            $weight,
            $label,
            $createdAt,
            $createdByUserId
        );
    }
}
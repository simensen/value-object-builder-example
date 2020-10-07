<?php

declare(strict_types=1);

namespace Example\Tests;

use DateTimeImmutable;
use Example\GraphedData;
use LogicException;
use PHPUnit\Framework\TestCase;

class GraphedDataTest extends TestCase
{
    /** @test */
    public function it_constructs_a_point()
    {
        $startX = 0;
        $startY = 0;
        $startZ = 0;

        $endX = null;
        $endY = null;
        $endZ = null;

        $colorR = 200;
        $colorG = 100;
        $colorB = 100;
        $colorA = 100;

        $weight = 10;
        $label = 'A Red Point';

        $createdAt = new DateTimeImmutable('now');
        $createdByUserId = 135;

        $graphedData = new GraphedData(
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

        $this->assertEquals($startX, $graphedData->getStartX());
        $this->assertEquals($startY, $graphedData->getStartY());
        $this->assertEquals($startZ, $graphedData->getStartZ());

        $this->assertNull($graphedData->getEndX());
        $this->assertNull($graphedData->getEndY());
        $this->assertNull($graphedData->getEndZ());

        $this->assertEquals($colorR, $graphedData->getColorR());
        $this->assertEquals($colorG, $graphedData->getColorG());
        $this->assertEquals($colorB, $graphedData->getColorB());
        $this->assertEquals($colorA, $graphedData->getColorA());

        $this->assertEquals($weight, $graphedData->getWeight());

        $this->assertTrue($graphedData->isLabeled());
        $this->assertEquals($label, $graphedData->getLabel());

        $this->assertEquals($createdAt, $graphedData->getCreatedAt());
        $this->assertEquals($createdByUserId, $graphedData->getCreatedByUserId());

        $this->assertTrue($graphedData->isPoint());
        $this->assertFalse($graphedData->isLine());
    }

    /** @test */
    public function it_constructs_a_line()
    {
        $startX = 0;
        $startY = 0;
        $startZ = 0;

        $endX = 0;
        $endY = 0;
        $endZ = 0;

        $colorR = 200;
        $colorG = 100;
        $colorB = 100;
        $colorA = 100;

        $weight = 10;
        $label = 'A Red Point';

        $createdAt = new DateTimeImmutable('now');
        $createdByUserId = 135;

        $graphedData = new GraphedData(
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

        $this->assertEquals($startX, $graphedData->getStartX());
        $this->assertEquals($startY, $graphedData->getStartY());
        $this->assertEquals($startZ, $graphedData->getStartZ());

        $this->assertEquals($endX, $graphedData->getEndX());
        $this->assertEquals($endY, $graphedData->getEndY());
        $this->assertEquals($endZ, $graphedData->getEndZ());

        $this->assertEquals($colorR, $graphedData->getColorR());
        $this->assertEquals($colorG, $graphedData->getColorG());
        $this->assertEquals($colorB, $graphedData->getColorB());
        $this->assertEquals($colorA, $graphedData->getColorA());

        $this->assertEquals($weight, $graphedData->getWeight());

        $this->assertTrue($graphedData->isLabeled());
        $this->assertEquals($label, $graphedData->getLabel());

        $this->assertEquals($createdAt, $graphedData->getCreatedAt());
        $this->assertEquals($createdByUserId, $graphedData->getCreatedByUserId());

        $this->assertFalse($graphedData->isPoint());
        $this->assertTrue($graphedData->isLine());
    }

    static public function provide_invalid_endpoints(): array
    {
        return [
            [0, null, null],
            [null, 0, null],
            [null, null, 0],
            [0, 0, null],
            [0, null, 0],
            [null, 0, 0],
        ];
    }

    /**
     * @test
     * @dataProvider provide_invalid_endpoints
     * @param int|null $endX
     * @param int|null $endY
     * @param int|null $endZ
     */
    public function it_wont_construct_partial_endpoint(?int $endX, ?int $endY, ?int $endZ)
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessageMatches('/endpoint/');

        $startX = 0;
        $startY = 0;
        $startZ = 0;

        $colorR = 200;
        $colorG = 100;
        $colorB = 100;
        $colorA = 100;

        $weight = 10;
        $label = 'A Red Thing';

        $createdAt = new DateTimeImmutable('now');
        $createdByUserId = 135;

        $graphedData = new GraphedData(
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

    static public function provide_valid_colors(): array
    {
        return [
            [255, 255, 255, 100], // white fully opaque
            [255, 255, 255, 0],   // white fully transparent
            [0, 0, 0, 100], // black fully opaque
            [0, 0, 0, 0],   // black fully transparent
        ];
    }

    /**
     * @test
     * @dataProvider provide_valid_colors
     * @param int $colorR
     * @param int $colorG
     * @param int $colorB
     * @param int $colorA
     */
    public function it_constructs_valid_colors(int $colorR, int $colorG, int $colorB, int $colorA)
    {
        $startX = 0;
        $startY = 0;
        $startZ = 0;

        $endX = null;
        $endY = null;
        $endZ = null;

        $weight = 10;
        $label = 'A Point';

        $createdAt = new DateTimeImmutable('now');
        $createdByUserId = 135;

        $graphedData = new GraphedData(
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

        $this->assertEquals($colorR, $graphedData->getColorR());
        $this->assertEquals($colorG, $graphedData->getColorG());
        $this->assertEquals($colorB, $graphedData->getColorB());
        $this->assertEquals($colorA, $graphedData->getColorA());
    }

    static public function provide_invalid_colors(): array
    {
        return [
            [-1, 0, 0, 0, '/^Red/'],
            [256, 0, 0, 0, '/^Red/'],
            [0, -1, 0, 0, '/^Green/'],
            [0, 256, 0, 0, '/^Green/'],
            [0, 0, -1, 0, '/^Blue/'],
            [0, 0, 256, 0, '/^Blue/'],
            [0, 0, 0, -1, '/^Alpha/'],
            [0, 0, 0, 256, '/^Alpha/'],
        ];
    }

    /**
     * @test
     * @dataProvider provide_invalid_colors
     * @param int $colorR
     * @param int $colorG
     * @param int $colorB
     * @param int $colorA
     * @param string $regex
     */
    public function it_wont_construct_invalid_color(int $colorR, int $colorG, int $colorB, int $colorA, string $regex)
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessageMatches($regex);

        $startX = 0;
        $startY = 0;
        $startZ = 0;

        $endX = null;
        $endY = null;
        $endZ = null;

        $weight = 10;
        $label = 'A Point';

        $createdAt = new DateTimeImmutable('now');
        $createdByUserId = 135;

        $graphedData = new GraphedData(
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

<?php

declare(strict_types=1);

namespace Example\Tests;

use Example\GraphedDataBuilder;
use PHPUnit\Framework\TestCase;

class GraphedDataBuilderTest extends TestCase
{
    private function graphedDataBuilder(): GraphedDataBuilder
    {
        return GraphedDataBuilder::new()
            ->pointAt(0, 0, 0)
            ->withCreatedByUserId(0);
    }

    /** @test */
    public function it_builds_a_point()
    {
        $startX = 100;
        $startY = 200;
        $startZ = 300;

        $createdByUserId = 135;

        $graphedData = GraphedDataBuilder::new()
            ->pointAt($startX, $startY, $startZ)
            ->withCreatedByUserId($createdByUserId)
            ->build();

        $this->assertEquals($startX, $graphedData->getStartX());
        $this->assertEquals($startY, $graphedData->getStartY());
        $this->assertEquals($startZ, $graphedData->getStartZ());

        $this->assertNull($graphedData->getEndX());
        $this->assertNull($graphedData->getEndY());
        $this->assertNull($graphedData->getEndZ());

        $this->assertEquals(GraphedDataBuilder::DEFAULT_COLOR_R, $graphedData->getColorR());
        $this->assertEquals(GraphedDataBuilder::DEFAULT_COLOR_G, $graphedData->getColorG());
        $this->assertEquals(GraphedDataBuilder::DEFAULT_COLOR_B, $graphedData->getColorB());
        $this->assertEquals(GraphedDataBuilder::DEFAULT_COLOR_A, $graphedData->getColorA());

        $this->assertEquals(GraphedDataBuilder::DEFAULT_WEIGHT, $graphedData->getWeight());

        $this->assertFalse($graphedData->isLabeled());

        $this->assertEquals($createdByUserId, $graphedData->getCreatedByUserId());

        $this->assertTrue($graphedData->isPoint());
        $this->assertFalse($graphedData->isLine());
    }

    /** @test */
    public function it_builds_a_line()
    {
        $startX = 100;
        $startY = 200;
        $startZ = 300;

        $endX = -100;
        $endY = -200;
        $endZ = -300;

        $createdByUserId = 135;

        $graphedData = GraphedDataBuilder::new()
            ->lineBetween($startX, $startY, $startZ, $endX, $endY, $endZ)
            ->withCreatedByUserId($createdByUserId)
            ->build();

        $this->assertEquals($startX, $graphedData->getStartX());
        $this->assertEquals($startY, $graphedData->getStartY());
        $this->assertEquals($startZ, $graphedData->getStartZ());

        $this->assertEquals($endX, $graphedData->getEndX());
        $this->assertEquals($endY, $graphedData->getEndY());
        $this->assertEquals($endZ, $graphedData->getEndZ());

        $this->assertEquals(GraphedDataBuilder::DEFAULT_COLOR_R, $graphedData->getColorR());
        $this->assertEquals(GraphedDataBuilder::DEFAULT_COLOR_G, $graphedData->getColorG());
        $this->assertEquals(GraphedDataBuilder::DEFAULT_COLOR_B, $graphedData->getColorB());
        $this->assertEquals(GraphedDataBuilder::DEFAULT_COLOR_A, $graphedData->getColorA());

        $this->assertEquals(GraphedDataBuilder::DEFAULT_WEIGHT, $graphedData->getWeight());

        $this->assertFalse($graphedData->isLabeled());

        $this->assertEquals($createdByUserId, $graphedData->getCreatedByUserId());

        $this->assertFalse($graphedData->isPoint());
        $this->assertTrue($graphedData->isLine());
    }
    
    
    /** @test */
    public function it_sets_rgb_independently_of_alpha()
    {
        $colorR = 200;
        $colorG = 100;
        $colorB = 50;

        $graphedData = $this->graphedDataBuilder()
            ->withRgb($colorR, $colorG, $colorB)
            ->build();

        $this->assertEquals($colorR, $graphedData->getColorR());
        $this->assertEquals($colorG, $graphedData->getColorG());
        $this->assertEquals($colorB, $graphedData->getColorB());
        $this->assertEquals(GraphedDataBuilder::DEFAULT_COLOR_A, $graphedData->getColorA());
    }

    /** @test */
    public function it_sets_alpha_independently_of_color()
    {
        $colorR = 200;
        $colorG = 100;
        $colorB = 50;
        $colorA = 75;

        $graphedData = $this->graphedDataBuilder()
            ->withRgb($colorR, $colorG, $colorB)
            ->withAlpha($colorA)
            ->build();

        $this->assertEquals($colorR, $graphedData->getColorR());
        $this->assertEquals($colorG, $graphedData->getColorG());
        $this->assertEquals($colorB, $graphedData->getColorB());
        $this->assertEquals($colorA, $graphedData->getColorA());
    }

    /** @test */
    public function it_sets_rgba()
    {
        $colorR = 200;
        $colorG = 100;
        $colorB = 50;
        $colorA = 75;

        $graphedData = $this->graphedDataBuilder()
            ->withRgba($colorR, $colorG, $colorB, $colorA)
            ->build();

        $this->assertEquals($colorR, $graphedData->getColorR());
        $this->assertEquals($colorG, $graphedData->getColorG());
        $this->assertEquals($colorB, $graphedData->getColorB());
        $this->assertEquals($colorA, $graphedData->getColorA());
    }

    /** @test */
    public function it_can_be_labeled()
    {
        $label = 'This is my label';

        $graphedData = $this->graphedDataBuilder()
            ->withLabel($label)
            ->build();

        $this->assertEquals($label, $graphedData->getLabel());
    }

    /** @test */
    public function it_can_be_unlabeled()
    {
        $label = 'This is my label';

        $graphedDataBuilder = $this->graphedDataBuilder()
            ->withLabel($label);

        $labeledGraphedData = $graphedDataBuilder->build();

        $this->assertTrue($labeledGraphedData->isLabeled());
        $this->assertEquals($label, $labeledGraphedData->getLabel());

        $unlabeledGraphedData = $graphedDataBuilder->withoutLabel()->build();

        $this->assertFalse($unlabeledGraphedData->isLabeled());
    }
}
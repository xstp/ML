<?php

namespace Rubix\ML\Tests\Manifold;

use Rubix\ML\Verbose;
use Rubix\ML\Estimator;
use Rubix\ML\Manifold\TSNE;
use Rubix\ML\Datasets\Unlabeled;
use Rubix\ML\Other\Helpers\DataType;
use Rubix\ML\Other\Loggers\BlackHole;
use Rubix\ML\Datasets\Generators\Blob;
use Rubix\ML\Kernels\Distance\Euclidean;
use Rubix\ML\Datasets\Generators\Agglomerate;
use PHPUnit\Framework\TestCase;
use InvalidArgumentException;

class TSNETest extends TestCase
{
    const TRAIN_SIZE = 30;

    protected $estimator;

    protected $generator;

    public function setUp()
    {
        $this->generator = new Agglomerate([
            'red' => new Blob([255, 0, 0], 3.),
            'green' => new Blob([0, 128, 0], 1.),
            'blue' => new Blob([0, 0, 255], 2.),
        ]);

        $this->estimator = new TSNE(1, 10, 12., 10., new Euclidean(), 500, 1e-7, 5);

        $this->estimator->setLogger(new BlackHole());
    }

    public function test_build_embedder()
    {
        $this->assertInstanceOf(TSNE::class, $this->estimator);
        $this->assertInstanceOf(Verbose::class, $this->estimator);
        $this->assertInstanceOf(Estimator::class, $this->estimator);

        $this->assertEquals(Estimator::EMBEDDER, $this->estimator->type());

        $this->assertNotContains(DataType::CATEGORICAL, $this->estimator->compatibility());
        $this->assertContains(DataType::CONTINUOUS, $this->estimator->compatibility());
    }

    public function test_predict()
    {
        $dataset = $this->generator->generate(self::TRAIN_SIZE);

        $embedding = $this->estimator->predict($dataset);

        $this->assertCount(self::TRAIN_SIZE, $embedding);

        // file_put_contents('test.json', json_encode($embedding, JSON_PRETTY_PRINT));
    }

    public function test_predict_incompatible()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->estimator->predict(Unlabeled::quick([['bad']]));
    }
}

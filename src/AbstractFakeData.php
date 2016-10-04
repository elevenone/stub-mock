<?php
// @codingStandardsIgnoreFile

namespace Jnjxp\Mockup;

use Faker\Generator;

abstract class AbstractFakeData
{

    protected $faker;

    public function __construct(Generator $faker)
    {
        $this->faker = $faker;
    }

    abstract public function __invoke();
}

<?php
// @codingStandardsIgnoreFile


use Jnjxp\Mockup\AbstractFakeData;

class DataThing extends AbstractFakeData
{
    public function __invoke()
    {
        $data = [];

        for ($i = 1; $i <= 10; $i++) {
            $data[] = (object) [
                'name' => $this->faker->name,
                'address' => $this->faker->address
            ];
        }

        return ['entries' => $data];
    }
}

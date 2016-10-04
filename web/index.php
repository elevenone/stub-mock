<?php
// @codingStandardsIgnoreFile

require '../vendor/autoload.php';

use Jnjxp\Mockup\Boot;

$boot = new Boot();
$mockup = $boot->mockup();

$templates = dirname(__DIR__) . '/templates';
$mockup->views($templates . '/views');
$mockup->layouts($templates . '/layouts');
$mockup->getView()->setLayout('default');

$mockup->mock('home', ['value' => 'This is something']);

$mockup->mock(
    'foo',
    function () {
        return [
            'value' => 'More Stuff'
        ];
    }
);

$mockup->mock('other', DataThing::class);

$mockup();


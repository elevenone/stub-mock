<?php
// @codingStandardsIgnoreFile


$links = [
    'home',
    'other',
    'foo'
];

$menu = $this->ul();

foreach ($links as $slug) {
    $menu->rawItem(
        $this->a('/' . $slug, $slug)
    );
}

echo $menu;

echo $this->getContent();

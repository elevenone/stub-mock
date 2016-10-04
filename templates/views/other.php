<?php
// @codingStandardsIgnoreFile

$list  = $this->ul();

foreach ($this->entries as $entry) {
    $list->item(sprintf('%s : %s', $entry->name, $entry->address));
}

echo $list;


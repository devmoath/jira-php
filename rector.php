<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__.'/src',
    ]);

//    $rectorConfig->rules([
//        InlineConstructorDefaultToPropertyRector::class,
//    ]);
//
//    $rectorConfig->sets([
//        LevelSetList::UP_TO_PHP_81,
//        SetList::CODE_QUALITY,
//        SetList::DEAD_CODE,
//        SetList::EARLY_RETURN,
//        SetList::TYPE_DECLARATION,
//        SetList::PRIVATIZATION,
//    ]);
};

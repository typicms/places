<?php

declare(strict_types=1);

use TypiCMS\Modules\Places\Models\Place;

return [
    'model' => Place::class,
    'linkable_to_page' => true,
    'per_page' => 30,
    'llms_txt' => true,
    'order' => [
        'title' => 'asc',
    ],
    'sidebar' => [
        'icon' => '<i class="icon-map-pin"></i>',
        'weight' => 40,
    ],
    'permissions' => [
        'read places' => 'Read',
        'create places' => 'Create',
        'update places' => 'Update',
        'delete places' => 'Delete',
    ],
];

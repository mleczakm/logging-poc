<?php

declare(strict_types=1);

use App\UserInterface\Http\AddDepartment;
use App\UserInterface\Http\GetDepartment;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routes) {
    $routes->add('add_department', '/department')
        ->controller(AddDepartment::class);

    $routes->add('get_department', '/department/{id}')
        ->controller(GetDepartment::class);
};
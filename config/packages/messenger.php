<?php

declare(strict_types=1);

use Symfony\Config\FrameworkConfig;

return static function (FrameworkConfig $framework) {
    $messenger = $framework->messenger();

    $bus = $messenger->bus('command_bus');
    $bus->middleware()->id('doctrine_transaction');
    $bus->middleware()->id('doctrine_ping_connection');
    $bus->middleware()->id('doctrine_close_connection');
};
<?php declare(strict_types=1);

use Gravatalonga\Container\Container;
use Psr\Container\ContainerInterface;

if (function_exists('container')) {
    function container(): ContainerInterface
    {
        return Container::getInstance();
    }
}
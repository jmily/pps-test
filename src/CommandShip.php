<?php
/**
 * Created by PhpStorm.
 * User: emilychen
 * Date: 8/05/2016
 * Time: 10:59 AM
 */

namespace PPS;


class CommandShip extends Battleship
{
    private static $instance;

    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }
}
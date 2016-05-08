<?php
/**
 * Created by PhpStorm.
 * User: emilychen
 * Date: 8/05/2016
 * Time: 10:51 AM
 */

namespace PPS;


abstract class OffensiveCraft extends Vessel
{
    protected $numOfCannon;

    public function fire()
    {
        $this->command->fire();
        $this->numOfCannon = 0;
    }

    public function raiseShield()
    {
        $this->command->raiseShield();
    }
}
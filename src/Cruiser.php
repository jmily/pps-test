<?php
/**
 * Created by PhpStorm.
 * User: emilychen
 * Date: 8/05/2016
 * Time: 10:55 AM
 */

namespace PPS;


class Cruiser extends OffensiveCraft
{
    public function __construct($command)
    {
        parent::__construct($command);
        $this->numOfCannon = 6;
    }
}
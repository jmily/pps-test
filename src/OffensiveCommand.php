<?php
/**
 * Created by PhpStorm.
 * User: emilychen
 * Date: 8/05/2016
 * Time: 11:11 AM
 */

namespace PPS;


class OffensiveCommand extends CommonCommand
{
    public function fire()
    {
        echo 'fire all the cannos';
    }

    public function raiseShield()
    {
        echo 'raise the shield';
    }

}
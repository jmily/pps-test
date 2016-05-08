<?php
/**
 * Created by PhpStorm.
 * User: emilychen
 * Date: 8/05/2016
 * Time: 10:49 AM
 */

require_once 'autoload.php';


$cargo = new \PPS\CargoSupportCraft(new \PPS\SupportCommand());


$fleet = new \PPS\Step2\FleetGenerator();

$supportCrafts = $fleet->generateSupportCraft(25);
$offensiveCrafts = $fleet->generateOffensiveCraft(25);




foreach ($supportCrafts as $support)
{
    $positionX = $support->getPositionX();
    $positionY = $support->getPositionY();

    $found = false;
    $searchNumber = 1;
    while(!$found)
    {
        $nearestPositions = array();

        if(($positionY + $searchNumber) <= 99)
        {
            $positionPairRight = $positionX.':'.($positionY + $searchNumber);

            $nearestPositions[] = $positionPairRight;
        }

        if(($positionY - $searchNumber) >= 0)
        {
            $positionPairLeft = $positionX.':'.($positionY - $searchNumber);
            $nearestPositions[] = $positionPairLeft;
        }

        if($positionX-$searchNumber >= 0)
        {
            $x = $positionX-$searchNumber;
            $positionTop = $x.':'.$positionY;
            $nearestPositions[] = $positionTop;
        }

        if($positionX + $searchNumber <= 99)
        {
            $x = $positionX+$searchNumber;
            $positionBottom = $x.':'.$positionY;
            $nearestPositions[] = $positionBottom;
        }

        //top right area
        if(($positionY + $searchNumber) <= 99 && ($positionX-$searchNumber >= 0) )
        {
            for($i=1; $i<= $searchNumber; $i++)
            {
                $x1 = $positionX-$searchNumber;
                $y1 = $positionY + $i;
                $xPair = $x1.':'.$y1;

                $nearestPositions[] = $xPair;

                $x2 = $positionX-$i;
                $y2 = $positionY + $searchNumber;
                $yPair = $x2.':'.$y2;

                if($xPair != $yPair)
                {
                    $nearestPositions[] = $yPair;
                }
            }
        }


        //top left area
        if(($positionY - $searchNumber) >= 0 && ($positionX-$searchNumber >= 0) )
        {
            for($i=1; $i<= $searchNumber; $i++)
            {
                $x1 = $positionX-$searchNumber;
                $y1 = $positionY - $i;
                $xPair = $x1.':'.$y1;

                $nearestPositions[] = $xPair;

                $x2 = $positionX-$i;
                $y2 = $positionY - $searchNumber;
                $yPair = $x2.':'.$y2;

                if($xPair != $yPair)
                {
                    $nearestPositions[] = $yPair;
                }
            }
        }

        //bottom left area
        if(($positionY - $searchNumber) >= 0 && ($positionX+$searchNumber <=99) )
        {
            for($i=1; $i<= $searchNumber; $i++)
            {
                $x1 = $positionX + $searchNumber;
                $y1 = $positionY - $i;
                $xPair = $x1.':'.$y1;

                $nearestPositions[] = $xPair;

                $x2 = $positionX + $i;
                $y2 = $positionY - $searchNumber;
                $yPair = $x2.':'.$y2;

                if($xPair != $yPair)
                {
                    $nearestPositions[] = $yPair;
                }
            }
        }

        //bottom right area
        if(($positionY + $searchNumber) <= 99 && ($positionX+$searchNumber <= 99) )
        {
            for($i=1; $i<= $searchNumber; $i++)
            {
                $x1 = $positionX + $searchNumber;
                $y1 = $positionY + $i;
                $xPair = $x1.':'.$y1;

                $nearestPositions[] = $xPair;

                $x2 = $positionX + $i;
                $y2 = $positionY + $searchNumber;
                $yPair = $x2.':'.$y2;

                if($xPair != $yPair)
                {
                    $nearestPositions[] = $yPair;
                }
            }
        }

        $result = loop($offensiveCrafts,$nearestPositions);
        $found = $result['found'];

        if($found)
        {
            echo 'Support Craft (x:'.$positionX.',y:'.$positionY.') pair with Offensive Craft (x:'.$result['ox'].', y:'.$result['oy'].')<br>';
        }
        $searchNumber++;
    }
}


function loop($offensiveCrafts,$nearestPositions)
{
    $found = false;
    $foundedOx = '';
    $foundedOy = '';
    foreach ($offensiveCrafts as $offensive)
    {
        if(!empty($nearestPositions))
        {
            foreach ($nearestPositions as $position)
            {
                $pair = explode(":",$position);
                $x = $pair[0];
                $y = $pair[1];

                if($offensive->getPositionX() == $x && $offensive->getPositionY() == $y)
                {
                    $found = true;
                    $foundedOx = $offensive->getPositionX();
                    $foundedOy = $offensive->getPositionY();

                    echo $foundedOx;
                    echo $foundedOy;
                    break 2;
                    die;
                }
            }
        }
    }
    $result['found'] = $found;
    $result['ox'] = $foundedOx;
    $result['oy'] = $foundedOy;

    return $result;
}




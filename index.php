<?php
/**
 * Created by PhpStorm.
 * User: emilychen
 * Date: 8/05/2016
 * Time: 10:49 AM
 */

require_once 'autoload.php';
set_time_limit(0);


$cargo = new \PPS\CargoSupportCraft(new \PPS\SupportCommand());


$fleet = new \PPS\Step2\FleetGenerator();

$supportCrafts = $fleet->generateSupportCraft(25);
$offensiveCrafts = $fleet->generateOffensiveCraft(25);

$pairedPositionArr = array();


/**
 * The algorithm
 * step1 - loop through the support crafts and look for the nearest offensive craft for each support craft.
 *
 * step2 - build the array for nearest points based on each search. I initialise the first time the search number = 1, then use this number
 * to look for whether an offensive craft is located at the nearest area.
 * If we consider the current support craft as a center point with a position of [4,3], the first time we need to look for
 * [4,2],[4,4],[3,2],[3,3],[3,4],[5,2],[5,3],[5,4].
 * if we can't find any offensive craft we do the second search, which needs to look for
 * [2,1],[2,2].... [2,5] and [3,1],[3,5],[4,1],[4,5],[5,1],[5,5],[6,1]...[6,5] etc. until it find a offensive position.
 *
 * step3 - once find a position, we also need to check whether the position has already been paired before, so we maintain an array for checking.
 *
 *
 */
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

        $result = loop($offensiveCrafts,$nearestPositions,$pairedPositionArr);
        $found = $result['found'];

        if($found)
        {
            $pairedPositionArr = $result['pairedPositionArr'];
            echo 'Support Craft (x:'.$positionX.',y:'.$positionY.') pair with Offensive Craft (x:'.$result['ox'].', y:'.$result['oy'].')<br>';
        }
        $searchNumber++;
    }
}


function loop($offensiveCrafts,$nearestPositions,$pairedPositionArr)
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

                    $foundedOx = $offensive->getPositionX();
                    $foundedOy = $offensive->getPositionY();

                    $hasPaired = false;
                    if(!empty($pairedPositionArr))
                    {
                        foreach ($pairedPositionArr as $pairedPosition)
                        {
                            if($pairedPosition == $foundedOx.':'.$foundedOy)
                            {
                                $hasPaired = true;
                                break;
                            }
                        }
                    }

                    if(!$hasPaired)
                    {
                        $pairedPositionArr[] = $foundedOx.':'.$foundedOy;
                        $found = true;
                    }

                    break 2;
                }
            }
        }
    }
    $result['found'] = $found;
    $result['ox'] = $foundedOx;
    $result['oy'] = $foundedOy;
    $result['pairedPositionArr'] = $pairedPositionArr;

    return $result;
}




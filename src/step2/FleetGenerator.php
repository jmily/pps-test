<?php
/**
 * Created by PhpStorm.
 * User: emilychen
 * Date: 8/05/2016
 * Time: 11:46 AM
 */

namespace PPS\Step2;


use PPS\Battleship;
use PPS\CargoSupportCraft;
use PPS\OffensiveCommand;
use PPS\SupportCommand;


class FleetGenerator
{

    private $randomPositionArr = array();

    public function __construct()
    {
        $numbers = range(0, 9999);
        shuffle($numbers);
        $this->randomPositionArr =  array_slice($numbers, 0, 50);

    }


    public function generateSupportCraft($number)
    {
        $supportCrafts = array();
        if($number >0 )
        {
            for($i = 0; $i<$number; $i++)
            {
                $cargoSupport = new CargoSupportCraft(new SupportCommand());


                $positionNumber = $this->randomPositionArr[array_rand($this->randomPositionArr)];
                $positionX = floor($positionNumber/100);
                $positionY = (($positionNumber/100) - $positionX) * 100;

                if(($key = array_search($positionNumber, $this->randomPositionArr)) !== false) {
                    unset($this->randomPositionArr[$key]);
                }

                $cargoSupport->setPositionNumber($positionNumber);
                $cargoSupport->setPositionX($positionX);
                $cargoSupport->setPositionY($positionY);
                $supportCrafts[] = $cargoSupport;
            }
        }


        return $supportCrafts;

    }

    public function generateOffensiveCraft($number)
    {
        $offensiveCraft = array();
        if($number >0 )
        {
            for($i = 0; $i<$number; $i++)
            {
                $battleShip = new Battleship(new OffensiveCommand());
                $positionNumber = $this->randomPositionArr[array_rand($this->randomPositionArr)];
                $positionX = floor($positionNumber/100);
                $positionY = (($positionNumber/100) - $positionX) * 100;
                if(($key = array_search($positionNumber, $this->randomPositionArr)) !== false) {
                    unset($this->randomPositionArr[$key]);
                }
                $battleShip->setPositionNumber($positionNumber);
                $battleShip->setPositionX($positionX);
                $battleShip->setPositionY($positionY);
                $offensiveCraft[] = $battleShip;
            }
        }

        return $offensiveCraft;
    }

    /**
     * @return array
     */
    public function getRandomPositionArr()
    {
        return $this->randomPositionArr;
    }

    /**
     * @param array $randomPositionArr
     */
    public function setRandomPositionArr($randomPositionArr)
    {
        $this->randomPositionArr = $randomPositionArr;
    }




}
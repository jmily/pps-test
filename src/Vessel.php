<?php
/**
 * Created by PhpStorm.
 * User: emilychen
 * Date: 8/05/2016
 * Time: 10:50 AM
 */

namespace PPS;


abstract class Vessel
{
    protected $command;
    protected $positionNumber;
    protected $positionX;
    protected $positionY;
    protected $paired;

    public function __construct($command)
    {
        $this->command = $command;
        $this->paired = false;
    }

    public function move()
    {
        $this->command->move();
    }

    /**
     * @return mixed
     */
    public function getPositionNumber()
    {
        return $this->positionNumber;
    }

    /**
     * @param mixed $positionNumber
     */
    public function setPositionNumber($positionNumber)
    {
        $this->positionNumber = $positionNumber;
    }

    /**
     * @return mixed
     */
    public function getPositionX()
    {
        return $this->positionX;
    }

    /**
     * @param mixed $positionX
     */
    public function setPositionX($positionX)
    {
        $this->positionX = $positionX;
    }

    /**
     * @return mixed
     */
    public function getPositionY()
    {
        return $this->positionY;
    }

    /**
     * @param mixed $positionY
     */
    public function setPositionY($positionY)
    {
        $this->positionY = $positionY;
    }

    /**
     * @return boolean
     */
    public function isPaired()
    {
        return $this->paired;
    }

    /**
     * @param boolean $paired
     */
    public function setPaired($paired)
    {
        $this->paired = $paired;
    }
    
    

}
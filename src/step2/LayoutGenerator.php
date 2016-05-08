<?php
/**
 * Created by PhpStorm.
 * User: emilychen
 * Date: 8/05/2016
 * Time: 11:38 AM
 */

namespace PPS\Step2;


class LayoutGenerator
{
    private $layout = array();

    public function __construct()
    {
        $this->layout = array();
        $locationNumber = 0;
        for($i = 0; $i<100; $i++)
        {
            for($j = 0; $j < 100; $j++)
            {
                $this->layout[$i][$j] = $locationNumber;
                $locationNumber++;
            }
        }
    }

    /**
     * @return array
     */
    public function getLayout()
    {
        return $this->layout;
    }

    /**
     * @param array $layout
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;
    }
    
    
    
    
}
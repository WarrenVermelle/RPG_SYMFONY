<?php

namespace App\Service;
use App\Entity\Champion;

class ChampionService
{
    public function getTrueImgProperty(Champion $champion)
    {
        
        $property = 'file';
        $property .= '_'.strtolower($champion->getRace());
        $champion->getGender()?$property.='H':$property.='F';
        return $property;
    }
}

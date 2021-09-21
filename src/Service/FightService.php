<?php

namespace App\Service;

use App\Entity\Champion;
use App\Entity\Monster;

class FightService 
{
    private $em;

    public function __construct($em)
    {
        $this->em = $em;
    }

    public function atkChamp(Champion $champion, Monster $monster)
    {
        $monster->setHp($monster->getHp()-($champion->getStrength()/2));
        $resultHp = $monster->getHp();
        $this->em->persist($monster);
        $this->em->flush();
        return $resultHp;
    }

    public function atkMonster(Champion $champion, Monster $monster)
    {
        $atkMonster = rand(1, $monster->getStrength()/2);
        $champion->setHp($champion->getHp()-$atkMonster);
        $resultHp = $champion->getHp();
        $this->em->persist($champion);
        $this->em->flush();
        return $resultHp;
    }
    
    

}
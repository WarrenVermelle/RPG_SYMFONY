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
        return $monster;
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
    
    public function xpWin(Champion $champion, Monster $monster)
    {
        $champion->setXp($champion->getXp()+$monster->getXp());
        $resultXp = $champion->getXp();
        $this->em->persist($champion);
        $this->em->flush();
        return $resultXp;
    }

    public function goldWin(Champion $champion, Monster $monster)
    {
        $champion->setGold($champion->getGold()+$monster->getGold());
        $resultGold = $champion->getGold();
        $this->em->persist($champion);
        $this->em->flush();
        return $resultGold;
    }

    public function levelUp(Champion $champion){
        $champion->setLevel($champion->getLevel() + 1);
        $this->em->persist($champion);
        $this->em->flush();
    }

    public function xpReset(Champion $champion){
        $champion->setXp(0);
        $this->em->persist($champion);
        $this->em->flush();
    }

}
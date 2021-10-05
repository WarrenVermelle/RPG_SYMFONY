<?php

namespace App\Service;


use App\Entity\Champion;
use App\Entity\Monster;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

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
        $champion->setStrength($champion->getStrength() + ($champion->getRace()->getRatioStrength() * $champion->getFaction()->getCoefStrength() * 5));
        $champion->setAgi($champion->getAgi() + ($champion->getRace()->getRatioAgi() * $champion->getFaction()->getCoefAgi() * 5));
        $champion->setIntel($champion->getIntel() + ($champion->getRace()->getRatioIntel() * $champion->getFaction()->getCoefIntel() * 5));
        $champion->setMaxHp($champion->getMaxHp() + ($champion->getRace()->getRatioHp() * $champion->getFaction()->getCoefHp() * 5));
        $champion->setMaxMp($champion->getMaxMp() + ($champion->getRace()->getRatioHp() * $champion->getFaction()->getCoefHp() * 5));
        $championCara = [
            $champion->getStrength(),
            $champion->getAgi(),
            $champion->getIntel(),
            $champion->getMaxMp(),
            $champion->getMaxHp()
        ];
        $this->em->persist($champion);
        $this->em->flush();
        return $championCara;
    }

    public function xpReset(Champion $champion){
        $champion->setXp(0);
        $this->em->persist($champion);
        $this->em->flush();
    }

    public function escape(Champion $champion,UrlGeneratorInterface $generator, Request $request){
       $monster = $request->getSession()->get('monster');
       match(true){
        $champion->getAgi() > $monster->getAgi() => $fuite = 1,
        ($monster->getAgi() - $champion->getAgi()) < 30 => $fuite = 2,
        ($monster->getAgi() - $champion->getAgi()) >= 30 && ($monster->getAgi() - $champion->getAgi()) <= 80 => $fuite = 3,
        ($monster->getAgi() - $champion->getAgi()) > 80 => $fuite = 10000
    };
        $fuite = random_int(1, $fuite);
        if ($fuite == 1){
           return true;
        }else{
            return false;
        };
    }
}
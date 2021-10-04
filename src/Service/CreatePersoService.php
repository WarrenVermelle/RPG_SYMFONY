<?php

namespace App\Service;

use App\Entity\Champion;

class CreatePersoService
{
    public function fillChampObj(Champion $champion)
    {
        $champion->setLevel(1);
        $champion->setGold(1000);
        $champion->setMaxHp(100*$champion->getRace()->getRatioHp()*$champion->getFaction()->getCoefHp());
        $champion->setMaxMp(100*$champion->getRace()->getRatioMp()*$champion->getFaction()->getCoefMp());
        $champion->setIntel(20*$champion->getRace()->getRatioIntel()*$champion->getFaction()->getCoefIntel());
        $champion->setStrength(20*$champion->getRace()->getRatioStrength()*$champion->getFaction()->getCoefStrength());
        $champion->setAgi(20*$champion->getRace()->getRatioAgi()*$champion->getFaction()->getCoefAgi());
        $champion->setXp(0);
        $champion->setActif(false);
        $champion->setHp($champion->getMaxHp());
        $champion->setMp($champion->getMaxMp());

        return $champion;
    }
}
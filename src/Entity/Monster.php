<?php

namespace App\Entity;

use App\Entity\Abstract\Humanoide;
use App\Repository\MonsterRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MonsterRepository::class)
 */
class Monster extends Humanoide
{
    
}

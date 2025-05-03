<?php
// src/Repository/ConqueteRepository.php
namespace App\Repository;

use App\Entity\Conquete;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ConqueteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Conquete::class);
    }

}

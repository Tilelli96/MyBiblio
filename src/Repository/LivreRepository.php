<?php

namespace App\Repository;

use App\Entity\Livre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Livre>
 */
class LivreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Livre::class);
    }

        /**
         * @return Livre[] Returns an array of Livre objects
         */
        public function findByRecherche(?string $categorie, ?string $titre, ?string $auteur): array
        {
            $qb = $this->createQueryBuilder('l');
            if ($categorie) {
                $qb->andWhere('l.categorie = :categorie')
                ->setParameter('categorie', $categorie);
            }

            if ($titre) {
                $qb->andWhere('l.titre = :titre')
                ->setParameter('titre', $titre);
            }

            if ($auteur) {
                $qb->andWhere('l.auteur = :auteur')
                ->setParameter('auteur', $auteur);
            }
            return $qb
                ->getQuery()
                ->getResult()
            ;
        }

    //    public function findOneBySomeField($value): ?Livre
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

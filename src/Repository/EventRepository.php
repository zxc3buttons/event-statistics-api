<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Event>
 *
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    public function save(Event $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Event $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param string $groupBy
     * @return Event[] Returns an array of Event objects
     */
    public function findAllAndGroupBy(string $groupBy): array
    {
        return $this->createQueryBuilder('e')
            ->select('e.'.$groupBy.' as ' . $groupBy, 'count(e) as count')
            ->groupBy('e.' . $groupBy)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param string $name
     * @return Event[] Returns an array of Event objects
     */
    public function findAllByName(string $name): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.name = :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param string $name
     * @param string $groupBy
     * @return Event[] Returns an array of Event objects
     */
    public function findAllByNameAndGroupBy(string $name, string $groupBy): array
    {
        return $this->createQueryBuilder('e')
            ->select('e.'.$groupBy.' as ' . $groupBy, 'count(e) as count')
            ->andWhere('e.name = :name')
            ->setParameter('name', $name)
            ->groupBy('e.' . $groupBy)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param string $creationDate
     * @return Event[] Returns an array of Event objects
     */
    public function findAllByDate(string $creationDate): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.createdAt = :createdAt')
            ->setParameter('createdAt', $creationDate)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param string $creationDate
     * @param string $groupBy
     * @return Event[] Returns an array of Event objects
     */
    public function findAllByDateAndGroupBy(string $creationDate, string $groupBy): array
    {
        return $this->createQueryBuilder('e')
            ->select('e.'.$groupBy.' as ' . $groupBy, 'count(e) as count')
            ->andWhere('e.createdAt = :createdAt')
            ->setParameter('createdAt', $creationDate)
            ->groupBy('e.' . $groupBy)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param string $name
     * @param string $creationDate
     * @return Event[] Returns an array of Event objects
     */
    public function findAllByNameAndDate(string $name, string $creationDate): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.createdAt = :createdAt')
            ->setParameter('createdAt', $creationDate)
            ->andWhere('e.name = :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param string $name
     * @param string $creationDate
     * @param string $groupBy
     * @return Event[] Returns an array of Event objects
     */
    public function findAllByNameAndDateAndGroupBy(string $name, string $creationDate, string $groupBy): array
    {
        return $this->createQueryBuilder('e')
            ->select('e.'.$groupBy.' as ' . $groupBy, 'count(e) as count')
            ->andWhere('e.createdAt = :createdAt')
            ->setParameter('createdAt', $creationDate)
            ->andWhere('e.name = :name')
            ->setParameter('name', $name)
            ->groupBy('e.' . $groupBy)
            ->getQuery()
            ->getResult();
    }
}

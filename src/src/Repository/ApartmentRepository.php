<?php

namespace App\Repository;

use App\Entity\Apartment;
use App\Entity\House;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @extends ServiceEntityRepository<Apartment>
 *
 * @method Apartment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Apartment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Apartment[]    findAll()
 * @method Apartment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApartmentRepository extends ServiceEntityRepository {

    use RepositoryTool;
    protected array $strategies = [
        'person_name'      => 'addPersonNameFilter',
        'person_last_name' => 'addPersonLastNameFilter',
        'street_name'      => 'addHouseStreetNameFilter',
        'number'           => 'addApartmentNumberFilter'
    ];

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Apartment::class);
    }

    /**
     * @param array $data
     * @param House $house
     * @return Apartment
     */
    public function createApartment(array $data, House $house): Apartment
    {
        $apartment = new Apartment();
        $apartment->setHouse($house);
        $this->hydrate($apartment, $data);
        $entityManager = $this->getEntityManager();
        $entityManager->persist($apartment);
        $entityManager->flush();

        return $apartment;
    }

    /**
     * @param array $filters
     * @return mixed
     */
    public function getApartmentList(array $filters): mixed
    {
        $limit = !empty($filters['limit']) ? $filters['limit'] : 25;
        $page = !empty($filters['page']) ? $filters['page'] : 1;

        $builder = $this->createQueryBuilder('a');
        $builder
            ->select('a', 'p', 'h')
            ->innerJoin('a.people', 'p')
            ->innerJoin('a.house', 'h')
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit);
        foreach ($this->strategies as $strategy => $callable_method)
        {
            if (array_key_exists($strategy, $filters))
            {
                $builder = $this->$callable_method($builder, $filters);
            }
        }

        return $builder->getQuery()->getResult();
    }

    /**
     * @param $builder
     * @param $filters
     * @return mixed
     */
    protected function addHouseStreetNameFilter($builder, $filters): mixed
    {
        $builder
            ->andWhere('h.street_name LIKE :street_name')
            ->setParameter('street_name', '%' . $filters['street_name'] . '%');

        return $builder;
    }

    /**
     * @param $builder
     * @param $filters
     * @return mixed
     */
    protected function addApartmentNumberFilter($builder, $filters): mixed
    {
        $builder
            ->andWhere('a.number = :number')
            ->setParameter('number', $filters['number']);

        return $builder;
    }

    /**
     * @param $builder
     * @param $filters
     * @return mixed
     */
    protected function addPersonLastNameFilter($builder, $filters): mixed
    {
        $builder
            ->andWhere('p.last_name LIKE :person_last_name')
            ->setParameter('person_last_name', '%' . $filters['person_last_name'] . '%');

        return $builder;
    }

    /**
     * @param $builder
     * @param $filters
     * @return mixed
     */
    protected function addPersonNameFilter($builder, $filters): mixed
    {
        $builder
            ->andWhere('p.name LIKE :name')
            ->setParameter('name', '%' . $filters['person_name'] . '%');

        return $builder;
    }

}

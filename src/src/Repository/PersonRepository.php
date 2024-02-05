<?php

namespace App\Repository;

use App\Entity\Apartment;
use App\Entity\Person;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Person>
 *
 * @method Person|null find($id, $lockMode = null, $lockVersion = null)
 * @method Person|null findOneBy(array $criteria, array $orderBy = null)
 * @method Person[]    findAll()
 * @method Person[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonRepository extends ServiceEntityRepository
{
    use RepositoryTool;

    protected array $strategies = [
        'name' => 'addPersonNameFilter',
        'last_name' => 'addPersonLastNameFilter',
        'street_name' => 'addHouseStreetNameFilter',
        'birthdate' => 'addPersonBirthdateFilter',
        'personal_id_number' => 'addPersonPersonalIdNumberFilter',
        'apartment_number' => 'addApartmentNumberFilter',
        'house_number' => 'addHouseNumberFilter',
    ];

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Person::class);
    }

    /**
     * @param array $data
     * @param Apartment $apartment
     * @return Person
     */
    public function createPerson(array $data, Apartment $apartment): Person
    {
        $person = new Person();
        $data['birthdate'] = \DateTime::createFromFormat('Y-m-d', $data['birthdate']);
        $person->setApartment($apartment);
        $this->hydrate($person, $data);
        $entityManager = $this->getEntityManager();
        $entityManager->persist($person);
        $entityManager->flush();

        return $person;
    }

    /**
     * @param array $filters
     * @return mixed
     */
    public function getPersonsByFilters(array $filters): mixed
    {
        $limit = !empty($filters['limit']) ? $filters['limit'] : 25;
        $page = !empty($filters['page']) ? $filters['page'] :  1;
        $builder = $this->createQueryBuilder('p')
                    ->select('p.id', 'p.name', 'p.birthdate', 'p.personal_id_number', 'p.last_name',
                        'h.number as house_number', 'h.street_name', 'a.number as apartment_number')
                    ->leftJoin('p.apartment', 'a')
                    ->leftJoin('a.house', 'h')
                    ->setFirstResult(($page - 1) * $limit)
                    ->setMaxResults($limit);
        foreach ($this->strategies as $strategy => $callable_method){
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
    protected function addPersonNameFilter($builder, $filters): mixed
    {
        $builder
            ->andWhere('p.name = :val')
            ->setParameter('val', $filters['name']);

        return $builder;
    }

    /**
     * @param $builder
     * @param $filters
     * @return mixed
     */
    protected function addHouseStreetNameFilter($builder, $filters): mixed
    {
        $builder
            ->andWhere('h.street_name = :street_name')
            ->setParameter('street_name', $filters['street_name']);

        return $builder;
    }

    /**
     * @param $builder
     * @param $filters
     * @return mixed
     */
    protected function addHouseNumberFilter($builder, $filters): mixed
    {
        $builder
            ->andWhere('h.number = :house_number')
            ->setParameter('house_number', $filters['house_number']);

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
            ->andWhere('a.number = :apartment_number')
            ->setParameter('apartment_number', $filters['apartment_number']);

        return $builder;
    }

    /**
     * @param $builder
     * @param $filters
     * @return mixed
     * @throws \Exception
     */
    protected function addPersonBirthdateFilter($builder, $filters): mixed
    {
        $builder
            ->andWhere('p.birthdate = :val')
            ->setParameter('val', new \DateTime($filters['birthdate']));

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
            ->andWhere('p.last_name LIKE :last_name')
            ->setParameter('last_name', '%'.$filters['last_name'].'%');

        return $builder;
    }

    /**
     * @param $builder
     * @param $filters
     * @return mixed
     */
    protected function addPersonPersonalIdNumberFilter($builder, $filters): mixed
    {
        $builder
            ->andWhere('p.personal_id_number LIKE :personal_id_number')
            ->setParameter('personal_id_number', '%'.$filters['personal_id_number'].'%');

        return $builder;
    }


}

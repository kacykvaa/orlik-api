<?php declare(strict_types=1);

namespace App\DataFixtures;


use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;

abstract class AbstractFixture extends Fixture
{
    private ManagerRegistry $doctrine;
    private Connection $connection;
    private ObjectManager $manager;

    abstract public function execute(): void;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
        $this->connection = $doctrine->getConnection();
    }

    /**
     * @throws DBALException
     */
    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;
        $this->execute();
    }

    public function saveEntities($entities) : void
    {
        if ($entities instanceof Collection) {
            $entities = $entities->toArray();
        }

        foreach ($entities as $entity) {
            $this->manager->persist($entity);
        }

        $this->manager->flush();
    }
}
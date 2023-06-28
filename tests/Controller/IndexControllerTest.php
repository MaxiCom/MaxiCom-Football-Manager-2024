<?php

namespace App\Tests\Controller;

use App\DataFixtures\AppFixtures;
use App\Entity\Team;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Response;

class IndexControllerTest extends WebTestCase
{
    private const TEST_PAGINATION_ITEMS_PER_PAGE = 12;

    private readonly KernelBrowser $client;
    private readonly Container $container;
    private readonly EntityManagerInterface $entityManager;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->client = self::createClient();
        $this->container = self::getContainer();

        $this->entityManager = $this->container->get(EntityManagerInterface::class);

        $purger = new ORMPurger($this->entityManager);
        $purger->purge();
    }

    public function testIndex(): void
    {
        $this->client->request('GET', '/');

        // Asserts that '/' URI matches the app_index route
        $this->assertRouteSame('app_index');

        // Asserts that index action return type is Response
        $response = $this->client->getResponse();
        $this->assertInstanceOf(Response::class, $response);

        // Asserts that the response was successful (HTTP status is 2xx).
        $this->assertResponseIsSuccessful();
    }

    /**
     * @throws Exception
     */
    public function testIndexPagination(): void
    {
        // Load the fixtures
        $fixtures = new AppFixtures();
        $fixtures->load($this->entityManager);

        // Get Team Repository
        $teamRepository = $this->entityManager->getRepository(Team::class);

        // Get team count
        $teamCount = $teamRepository->count([]);

        // Get expected page count
        $expectedPageCount = $teamCount / self::TEST_PAGINATION_ITEMS_PER_PAGE;
        $ceilExpectedPageCount = ceil($expectedPageCount);

        // Get the KnpPaginatorBundle service
        $paginator = $this->container->get(PaginatorInterface::class);

        // Create a query or fetch data to paginate
        $query = $this->entityManager
            ->getRepository(Team::class)
            ->createQueryBuilder('team')
            ->getQuery();

        // Paginate the query
        $pagination = $paginator->paginate(
            $query,
            1,
            self::TEST_PAGINATION_ITEMS_PER_PAGE,
        );

        // Assert that the pagination object is an instance of PaginationInterface
        $this->assertInstanceOf(PaginationInterface::class, $pagination);

        // Assert that the pagination contains the expected number of items
        $this->assertEquals($teamCount, $pagination->getTotalItemCount());

        // Assert that the pagination contains the expected number of pages
        $this->assertEquals($ceilExpectedPageCount, $pagination->getPageCount());
    }
}

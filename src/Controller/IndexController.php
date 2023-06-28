<?php

namespace App\Controller;

use App\Repository\TeamRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    private const PAGINATION_ITEMS_PER_PAGE = 12;

    #[Route('/', name: 'app_index')]
    public function index(
        TeamRepository $teamRepository,
        PaginatorInterface $paginator,
        Request $request,
    ): Response
    {
        $query = $teamRepository
            ->createQueryBuilder('team')
            ->getQuery();

        $teamsPagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            self::PAGINATION_ITEMS_PER_PAGE,
        );

        return $this->render('index/index.html.twig', [
            'teamsPagination' => $teamsPagination,
        ]);
    }
}

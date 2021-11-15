<?php

namespace App\Controller;

use App\Model\UserQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/primus", name="primus_")
 */
class PrimusController extends AbstractController
{
    /**
     * @Route("", name="index")
     */
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/PrimusController.php',
        ]);
    }

    /**
     * @Route("/{page}", name="page", requirements={"page"="\d{3,}"})
     * @param string $page
     * @param UserQuery $query
     * @return Response
     */
    public function page(string $page, UserQuery $query): Response
    {
//        $query::create()->setFormatter($formatter);

        $data = ['hell' => 'hello world!'];
        return $this->json($data);
    }
}

<?php

    namespace App\Controller\Api;

    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;

    /**
     * @Route("/first", name="first_")
     */
    class FirstController extends AbstractController
    {
        /**
         *@Route("", name="index")
         */
        public function index(): Response
        {
            return $this->json([
                'message' => 'Welcome to your new controller!',
                'path' => 'src/Controller/Api/FirstController.php',
            ]);
        }
    }

<?php

    namespace App\Controller\Api\Catalog;

    use App\Model\ProductCategoryQuery;
    use App\Model\ProductCategoryRelQuery;
    use App\Model\ProductPropertyQuery;
    use App\Service\Catalog\ProductService;
    use Creonit\RestBundle\Handler\RestHandler;
    use Propel\Runtime\Exception\PropelException;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;

    /**
     *@Route("/test", name="test_")
     */
    class TestController extends AbstractController
    {
        protected $productServ;
        protected $handler;

        public function __construct(ProductService $service, RestHandler $handler)
        {
            $this->productServ = $service;
            $this->handler = $handler;
        }

        /**
         * @return Response
         * @throws PropelException
         * @Route("", name="index")
         */
        public function index(): Response
        {
            $product = $this->productServ->getProductById(35);
            ProductPropertyQuery::create()->filterByProduct($product)->find();
//            $category = ProductCategoryQuery::create()
//                ->leftJoin();
            $category = ProductCategoryRelQuery::create()
                ->filterByProduct($product)
                ->find();
            $this->handler->checkFound($product);
            $this->handler->checkFound($category);
            $data = ['product' => $product, 'category' => $category];
//            $this->handler->data->set($product);
            $this->handler->data->set($data);
            return $this->handler->response();
        }
    }

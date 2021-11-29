<?php

    namespace App\Controller\Api\Catalog;

    use App\Service\Catalog\ProductService;
    use App\Validator\Constraints\NotBlank;
    use Creonit\RestBundle\Annotation\Parameter\PathParameter;
    use Creonit\RestBundle\Handler\RestHandler;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Component\Validator\Constraints\Positive;


    /**
     * @Route("/products", name="product_")
     */
    class ProductsController extends AbstractController
    {
        /**
         * Получение списка всех продуктов
         *
         * @Route("", name="all")
         */
        public function getAllProducts(RestHandler $handler, ProductService $service)
        {
            $products = $service->getAllProducts();
        }

        /**
         * Получить список продуктов по категории
         *
         * @PathParameter("category", type="string", description="Название категории")
         *
         * @Route("/categories/{category}", name="by_category", requirements={"category"="\w+"})
         */
        public function getProductsByCategory(RestHandler $handler, ProductService $service, $category): Response
        {
            $products = $service->getAllProducts();

            return $handler->response();
        }

        /**
         * Получить информацию о продукте по ID
         *
         * @PathParameter("id", type="string", description="Идентификатор товара")
         *
         * @Route("/{id}", name="product_by_id", methods={"GET"}, requirements={"id"="[1-9]{1}\d*"})
         */
        public function getProductById(RestHandler $handler, ProductService $service, $id): Response
        {

            $product = $service->getProductById($id);

            $handler->checkFound($product);


            $handler->data->set($product);
            return $handler->response();
        }

        /**
         * Получить список категорий продуктов
         *
         * @Route("/categories", name="categories_list", methods={"GET"})
         */
        public function getCategoriesList()
        {

        }
    }

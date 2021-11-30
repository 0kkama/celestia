<?php

    namespace App\Controller\Api\Catalog;

    use App\Normalizer\ProductBrandNormalizer;
    use App\Normalizer\ProductCategoryNormalizer;
    use App\Normalizer\ProductNormalizer;
    use App\Service\Catalog\ProductService;
    use App\Validator\Constraints\NotBlank;
    use Creonit\RestBundle\Annotation\Parameter\PathParameter;
    use Creonit\RestBundle\Annotation\Parameter\QueryParameter;
    use Creonit\RestBundle\Handler\RestHandler;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Component\Validator\Constraints\Choice;
    use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
    use Symfony\Component\Validator\Constraints\LessThanOrEqual;
    use Symfony\Component\Validator\Constraints\Positive;
    use Symfony\Component\Validator\Constraints\PositiveOrZero;


    /**
     * @Route("/products", name="product_")
     */
    class ProductsController extends AbstractController
    {

        /**
         * Получить список продуктов по категории
         *
         * @PathParameter("category", type="string", description="Название категории")
         *
         * @QueryParameter("view", description="Определяет количество выводимых элементов")
         * @QueryParameter("page", description="указывает текущую страницу")
         * @QueryParameter("min_price", description="Устанаваливает минимальную цену товара для фильтрации")
         * @QueryParameter("max_price", description="Устанаваливает максимальную цену товара для фильтрации")
         * @QueryParameter("title", description="Позволяет фильтровать товары по названию")
         * @QueryParameter("brand", description="Позволяет фильтровать товары по бренду")
         *
         * @Route("/categories/{category}", name="by_category", methods={"GET"})
         */
        public function getProductsByCategory(RestHandler $handler, ProductService $service, $category): Response
        {
            if (!$handler->getRequest()->query->get('view')) {
                $handler->getRequest()->query->set('view', 'table');
            }

            if(!$handler->getRequest()->query->get('page')) {
                $handler->getRequest()->query->set('page', 1);
            }

            //            фильтры: название, цена(от и до), бренд (выпадающий список на основе товаров в категории)
            $handler->validate([
                'query' => [
                    'view' => [new NotBlank(), new Choice(['tile', 'table'])],
                    'page' => [],
                    'title' => [],
//                    'min_price' => [new Positive(), new LessThanOrEqual($handler->getRequest()->query->get('max_price'))],
//                    'max_price' => [new Positive(), new GreaterThanOrEqual($handler->getRequest()->query->get('min_price'))],
                    'brand' => [],
                ]
            ]);

//            $page = $handler->getRequest()->query->get('page');
//            $limit = ($handler->getRequest()->query->get('view') === 'table') ? 9 : 20;
//
//            $products = $service->paginateProductsByCategoryId($category, $page, $limit);
            $products = $service->paginateProductsByCategoryId($category, 1, 3);
            $handler->checkFound($products);

            $brands = $service->getBrandsListByCategoryId($category);
            $handler->checkFound($brands);

            //            dump($products);
                        dump($brands);

            $data = ['products' => $products, 'brand_list' => $brands];
//
            $handler->data->addGroup(ProductNormalizer::GROUP_LIST);
            $handler->data->addGroup(ProductBrandNormalizer::GROUP_LIST);
            $handler->data->set($data);

//            $data = [1 => '1' , 2 => '2'];
//            return $this->json($data);
            return $handler->response();
        }

        /**
         * Получить информацию о продукте по ID
         *
         * @PathParameter("id", type="string", description="Идентификатор товара")
         *
         * @Route("product/{id}", name="product_by_id", methods={"GET"}, requirements={"id"="[1-9]{1}\d*"})
         */
        public function getProductById(RestHandler $handler, ProductService $service, $id): Response
        {
            $product = $service->getProductById($id);
            $category = $service->getCategoryByProduct($product);
            $properties = $service->getPropertiesOfProduct($product);

            $handler->checkFound($product);
            $handler->checkFound($category);
            $handler->checkFound($properties);

            $handler->data->addGroup(ProductNormalizer::GROUP_PAGE);
            $handler->data->addGroup(ProductCategoryNormalizer::GROUP_PRODUCT);

            $data = [
                'product' => $product,
                'properties' => $properties,
                'category' => $category,
            ];

            $handler->data->set($data);

            return $handler->response();
        }

        /**
         * Получить список категорий продуктов
         *
         * @Route("/categories", name="categories_list", methods={"GET"})
         */
        public function getCategoriesList(RestHandler $handler, ProductService $service): Response
        {
            $categories = $service->getCategoriesList();

//            dump($categories);

            $handler->checkFound($categories);
            $handler->data->addGroup(ProductCategoryNormalizer::GROUP_LIST);
            $handler->data->set($categories);
            return $handler->response();
        }
    }

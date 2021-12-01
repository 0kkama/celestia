<?php

    namespace App\Controller\Api\Catalog;

    use App\Normalizer\ProductBrandNormalizer;
    use App\Normalizer\ProductCategoryNormalizer;
    use App\Normalizer\ProductNormalizer;
    use App\Service\Catalog\ProductFiltersService;
    use App\Service\Catalog\ProductService;
    use App\Validator\Constraints\NotBlank;
    use Creonit\RestBundle\Annotation\Parameter\PathParameter;
    use Creonit\RestBundle\Annotation\Parameter\QueryParameter;
    use Creonit\RestBundle\Annotation\Parameter\RequestParameter;
    use Creonit\RestBundle\Handler\RestHandler;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Component\Validator\Constraints\Choice;
    use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
    use Symfony\Component\Validator\Constraints\LessThanOrEqual;
    use Symfony\Component\Validator\Constraints\Positive;
    use Symfony\Component\Validator\Constraints\Range;

    /**
     * @Route("/products", name="product_")
     */
    class ProductsController extends AbstractController
    {
        /**
         * Получить список продуктов по категории
         *
         * @PathParameter("category", type="string", description="ID категории")
         * @QueryParameter("view", description="Определяет количество выводимых элементов")
         * @QueryParameter("page", description="Указывает текущую страницу")
         * @QueryParameter("min_price", description="Устанаваливает минимальную цену товара для фильтрации")
         * @QueryParameter("max_price", description="Устанаваливает максимальную цену товара для фильтрации")
         * @QueryParameter("title", description="Позволяет фильтровать товары по названию (url)")
         * @QueryParameter("brand", description="Позволяет фильтровать товары по бренду")
         *
         * @Route("/categories/{category}", name="by_category", methods={"GET"})
         */
        public function getProductsByCategory(RestHandler $handler, ProductService $productService, $category, ProductFiltersService $filtersService): Response
        {
            $filtersService->setDefaultParamsForFilters($handler);

            $handler->validate([
                'query' => [
                    'view' => [new NotBlank(), new Choice(['tile', 'table'])],
                    'min_price' => [new Positive(), new LessThanOrEqual($handler->getRequest()->query->get('max_price'))],
                    'max_price' => [new Positive(), new GreaterThanOrEqual($handler->getRequest()->query->get('min_price'))],
                ]
            ]);

            $itemsPerPageInTile = 9;
            $itemsPerPageInTable = 20;

            $page = $handler->getRequest()->query->get('page');
            $itemsLimit = ($handler->getRequest()->query->get('view') === 'tile') ? $itemsPerPageInTile : $itemsPerPageInTable;
            $filters = $filtersService->getFiltersCollection($handler);

            $brands = $productService->getBrandsListByCategoryId($category);
            $handler->checkFound($brands);

            $products = $productService->paginateProductsByCategoryId($category, $page, $itemsLimit, $filters);
            $handler->checkFound($products);

            $data = ['products' => $products, 'brands' => $brands];

            $handler->data->addGroup(ProductNormalizer::GROUP_LIST);
            $handler->data->addGroup(ProductBrandNormalizer::GROUP_LIST);
            $handler->data->set($data);

            return $handler->response();
        }

        /**
         * Получить информацию о продукте по ID
         *
         * @PathParameter("id", type="string", description="Идентификатор товара")
         *
         * @Route("/product/{id}", name="product_by_id", methods={"GET"}, requirements={"id"="[1-9]{1}\d*"})
         */
        public function getProductById(RestHandler $handler, ProductService $service, $id): Response
        {
            $product = $service->getProductById($id);

            $handler->checkFound($product);
            $handler->data->addGroup(ProductNormalizer::GROUP_PAGE);
            $handler->data->addGroup(ProductCategoryNormalizer::GROUP_PRODUCT);
            $handler->data->set($product);

            return $handler->response();
        }


        /**
         * Дать оценку продукту
         *
         * @RequestParameter("rating", type="integer", description="Оценка продукта пользователем")
         *
         * @Route("/product/{id}", name="vote_for_product", methods={"POST"}, requirements={"id"="[1-9]{1}\d*"})
         */
        public function voteForProduct(RestHandler $handler, ProductService $service, $id): Response
        {
            $handler->checkAuthorization();

            $user = $this->getUser();

            $productId = 27;
            $userId = 1;

            $handler->validate([
                'request' => [
                    'rating' => [new NotBlank(), new Range(['min' => 1, 'max' => 5])],
                ]
            ]);

            $rating = $handler->getRequest()->get('rating');

            if ($service->hadUserAlreadyVoted($productId, $userId)) {
                $handler->error->set('request/rating', 'Вы уже голосовали за данный товар');
                return $handler->response();
            }

            $service->takeVote($id, $userId, $rating);
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
            $handler->checkFound($categories);
            $handler->data->addGroup(ProductCategoryNormalizer::GROUP_LIST);
            $handler->data->set($categories);
            return $handler->response();
        }
    }

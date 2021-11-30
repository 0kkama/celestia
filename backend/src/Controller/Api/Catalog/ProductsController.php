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
    use Creonit\RestBundle\Handler\RestHandler;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Component\Validator\Constraints\Choice;
    use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
    use Symfony\Component\Validator\Constraints\LessThanOrEqual;
    use Symfony\Component\Validator\Constraints\Positive;


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
         * @QueryParameter("title", description="Позволяет фильтровать товары по названию (url)")
         * @QueryParameter("brand", description="Позволяет фильтровать товары по бренду")
         *
         * @Route("/categories/{category}", name="by_category", methods={"GET"})
         */
        public function getProductsByCategory(RestHandler $handler, ProductService $productService, $category, ProductFiltersService $checkerService): Response
        {
            $itemsPerPageInTile = 9;
            $itemsPerPageInTable = 20;
            $checkerService->setDefaultParamsForFilters($handler);

            $handler->validate([
                'query' => [
                    'view' => [new NotBlank(), new Choice(['tile', 'table'])],
                    'min_price' => [new Positive(), new LessThanOrEqual($handler->getRequest()->query->get('max_price'))],
                    'max_price' => [new Positive(), new GreaterThanOrEqual($handler->getRequest()->query->get('min_price'))],
                ]
            ]);

            $page = $handler->getRequest()->query->get('page');
            $limit = ($handler->getRequest()->query->get('view') === 'tile') ? $itemsPerPageInTile : $itemsPerPageInTable;
            $title = $handler->getRequest()->query->has('title') ? $handler->getRequest()->query->get('title') : null;
            $minPrice = $handler->getRequest()->query->has('min_price') ? $handler->getRequest()->query->get('min_price') : null;
            $maxPrice = $handler->getRequest()->query->has('max_price') ? $handler->getRequest()->query->get('max_price') : null;
            $brand = $handler->getRequest()->query->has('brand') ? $handler->getRequest()->query->get('brand') : null;

            $brands = $productService->getBrandsListByCategoryId($category);
            $handler->checkFound($brands);

            $products = $productService->paginateProductsByCategoryId($category, $page, $limit, $brand, $title, $minPrice, $maxPrice);
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

<?php

    namespace App\Controller\Api\Catalog;

    use App\Helper\ProductParametersProvider;
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
         * Получить список категорий продуктов
         *
         * @Route("/categories", name="categories_list", methods={"GET"})
         */
        public function getCategoriesList(RestHandler $handler, ProductService $productService): Response
        {
            $categories = $productService->getCategoriesList();

            $handler->data->addGroup(ProductCategoryNormalizer::GROUP_LIST);
            $handler->data->set($categories);
            return $handler->response();
        }

        /**
         * Получить информацию о продукте по URL
         *
         * @PathParameter("url", type="string", description="Slug товара или его ID")
         *
         * @Route("/product/{url}", name="product_by_url", methods={"GET"})
         */
        public function getProduct(RestHandler $handler, ProductService $productService, $url): Response
        {
            $product = $productService->getProductByUrl($url);

            if (is_numeric($url) && empty($product->getId())) {
                $product = $productService->getProductById($url);
            }

            $handler->checkFound($product->getId());
            $handler->data->addGroup(ProductNormalizer::GROUP_PAGE);
            $handler->data->addGroup(ProductCategoryNormalizer::GROUP_PRODUCT);
            $handler->data->set($product);

            return $handler->response();
        }

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
        public function getProductsByCategory(RestHandler $handler, ProductService $productService, $category, ProductParametersProvider $parametersProvider): Response
        {
            $parametersProvider->setDefaultParamsForFilters($handler->getRequest());

            $handler->validate([
                'query' => [
                    'view' => [new NotBlank(), new Choice(['tile', 'table'])],
                    'min_price' => [new Positive(), new LessThanOrEqual($handler->getRequest()->query->get('max_price'))],
                    'max_price' => [new Positive(), new GreaterThanOrEqual($handler->getRequest()->query->get('min_price'))],
                ]
            ]);

            $page = $handler->getRequest()->query->get('page');
            $filters = $parametersProvider->getFiltersCollection($handler->getRequest());

            $products = $productService->paginateProductsByCategoryId($category, $filters);
            $handler->data->addGroup(ProductNormalizer::GROUP_LIST);
            $handler->data->set($products);

            return $handler->response();
        }

        /**
         * Получить список брендов по категории
         *
         * @PathParameter("category", type="string", description="Идентификатор категории")
         *
         * @Route("/categories/{category}/brands", name="by_category", methods={"GET"})
         */
        public function getProductBrandsByCategory(RestHandler $handler, ProductService $productService, $category)
        {
            $brands = $productService->getBrandsListByCategory($category);
            $handler->data->set($brands);

            return $handler->response();
        }

        /**
         * Дать оценку продукту
         *
         * @PathParameter("product", type="string", description="URL продукта")
         * @RequestParameter("rating", type="integer", description="Оценка продукта пользователем")
         *
         * @Route("/product/{url}/vote", name="vote_for_product", methods={"POST"}, requirements={"id"="[1-9]{1}\d*"})
         */
        public function voteForProduct(RestHandler $handler, ProductService $productService, $url): Response
        {
            $handler->validate([
                'request' => [
                    'rating' => [new NotBlank(), new Range(['min' => 1, 'max' => 5])],
                ]
            ]);

            $rating = $handler->getRequest()->get('rating');

            if (is_null($product = $productService->getProductByUrl($url))) {
                $handler->error->send('Продукт не существует!', 404, 404);
            }

            $productService->takeVote($product, $rating);
            return $handler->response('Ваша оценка засчитана!');
        }
    }

<?php

    namespace App\Helper;

    use Symfony\Component\HttpFoundation\Request;

    class ProductParametersProvider
    {
        protected ProductParametersDTO $productParams;

        public function __construct(ProductParametersDTO $params)
        {
            $this->productParams = $params;
        }

        public function setDefaultParamsForFilters(Request $request): void
        {
            if (!$request->query->has('view')) {
                $request->query->set('view', 'table');
            }

            if (!$request->query->has('page')) {
                $request->query->set('page', 1);
            }

            if (!$request->query->has('min_price')) {
                $request->query->set('min_price', 1);
            }

            if (!$request->query->has('max_price')) {
                $request->query->set('max_price', 1000);
            }

        }

        public function getFiltersCollection(Request $request) : ProductParametersDTO
        {
            $itemsPerPageInTile = 9;
            $itemsPerPageInTable = 20;

            $page = $request->query->has('page') ? $request->query->get('page') : 1;
            $itemsPerPage = ($request->query->get('view') === 'tile') ? $itemsPerPageInTile : $itemsPerPageInTable;
            $productTitle = $request->query->has('title') ? $request->query->get('title') : null;
            $minPrice = $request->query->has('min_price') ? $request->query->get('min_price') : null;
            $maxPrice = $request->query->has('max_price') ? $request->query->get('max_price') : null;
            $brand = $request->query->has('brand') ? $request->query->get('brand') : null;

            $this->productParams
                ->setPage($page)
                ->setItemsPerPage($itemsPerPage)
                ->setProductTitle($productTitle)
                ->setBrand($brand)
                ->setMinPrice($minPrice)
                ->setMaxPrice($maxPrice);

            return $this->productParams;
        }
    }

<?php

    namespace App\Service\Catalog;

    use Creonit\RestBundle\Handler\RestHandler;

    class ProductFiltersService
    {
        public function setDefaultParamsForFilters(RestHandler $handler): void
        {
            if (!$handler->getRequest()->query->has('view')) {
                $handler->getRequest()->query->set('view', 'table');
            }

            if(!$handler->getRequest()->query->has('page')) {
                $handler->getRequest()->query->set('page', 1);
            }

            if(!$handler->getRequest()->query->has('min_price')) {
                $handler->getRequest()->query->set('min_price', 1);
            }

            if(!$handler->getRequest()->query->has('max_price')) {
                $handler->getRequest()->query->set('max_price', 1000);
            }
        }

        public function getFiltersCollection(RestHandler $handler) : array
        {
            $filters = [];
            $filters['productTitle'] = $handler->getRequest()->query->has('title') ? $handler->getRequest()->query->get('title') : null;
            $filters['minPrice'] = $handler->getRequest()->query->has('min_price') ? $handler->getRequest()->query->get('min_price') : null;
            $filters['maxPrice'] = $handler->getRequest()->query->has('max_price') ? $handler->getRequest()->query->get('max_price') : null;
            $filters['brand'] = $handler->getRequest()->query->has('brand') ? $handler->getRequest()->query->get('brand') : null;

            return $filters;
        }
    }

<?php

    namespace App\Service\Catalog;

    use Creonit\RestBundle\Handler\RestHandler;

    class ProductFiltersService
    {
        public function setDefaultParamsForFilters(RestHandler $handler) {
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
    }

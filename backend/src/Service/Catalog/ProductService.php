<?php

    namespace App\Service\Catalog;

    use App\Model\Product;
    use App\Model\ProductQuery;
    use Propel\Runtime\Collection\ArrayCollection;
    use Propel\Runtime\Collection\ObjectCollection;

    class ProductService
    {
        public function getAllProducts(): ObjectCollection
        {
            return ProductQuery::create()->find();
        }

        public function getProductById($id): Product
        {
            return ProductQuery::create()->findOneById($id);
        }

        public function getProductBySlug($slug): Product
        {
            return ProductQuery::create()->findOneBySlug($slug);
        }

        public function getProductByName(string $name): Product
        {
            return ProductQuery::create()->findOneByTitle($name);
        }
    }

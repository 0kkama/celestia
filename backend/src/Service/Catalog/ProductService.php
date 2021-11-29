<?php

    namespace App\Service\Catalog;

    use App\Model\Product;
    use App\Model\ProductCategory;
    use App\Model\ProductCategoryQuery;
    use App\Model\ProductPropertyQuery;
    use App\Model\ProductQuery;
    use Propel\Runtime\Collection\ArrayCollection;
    use Propel\Runtime\Collection\ObjectCollection;

    class ProductService
    {
        public function getAllProducts()
        {
            return ProductQuery::create()->find();
        }

        public function getAllCategories()
        {
            return ProductCategoryQuery::create()->find();
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

        public function getCategoryByProduct(Product $product)
        {
            return ProductCategoryQuery::create()
                ->useProductCategoryRelQuery()
                ->filterByProduct($product)
                    ->endUse()
                ->find();
        }

        public function getPropertiesOfProduct(Product $product)
        {
            return ProductPropertyQuery::create()
                ->filterByProduct($product)
                ->find();
        }
    }

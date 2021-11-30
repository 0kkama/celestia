<?php

    namespace App\Service\Catalog;

    use App\Model\Map\ProductCategoryTableMap;
    use App\Model\Product;
    use App\Model\ProductCategory;
    use App\Model\ProductCategoryQuery;
    use App\Model\ProductCategoryRelQuery;
    use App\Model\ProductPropertyQuery;
    use App\Model\ProductQuery;
    use Propel\Runtime\Collection\ArrayCollection;
    use Propel\Runtime\Collection\ObjectCollection;
    use Propel\Runtime\Formatter\ObjectFormatter;
    use Propel\Runtime\Propel;

    class ProductService
    {
        public function getAllProducts()
        {
            return ProductQuery::create()->find();
        }

        public function paginateProductsByCategoryId($id, $page, $limit)
        {
            return ProductQuery::create()
                ->leftJoin('ProductRating')
                ->withColumn('avg(ProductRating.rate)', 'product_rate')
                ->joinWithProductCategoryRel()
                ->where('ProductCategoryRel.product_category_id = '. $id)
                ->groupBy('Product.id')
                ->orderBy('product_rate')
//                ->paginate(1, 3);
                ->find();
        }

        public function getCategoriesList()
        {
            return ProductCategoryQuery::create()
                    ->join('ProductCategoryRel')
                    ->withColumn('count(*)', 'amount')
                    ->groupBy('ProductCategoryRel.product_category_id')
                    ->find();
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

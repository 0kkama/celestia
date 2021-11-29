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

        public function getCategoriesList()
        {
            # SELECT pc.id, pc.title, pc.content, pc.slug, pc.image_id, pc.sortable_rank,
            #        COUNT(*) as products_amount
            # FROM product_category_rel AS pcr
            # JOIN product_category AS pc ON pcr.product_category_id = pc.id
            # GROUP BY product_category_id

            $categories = ProductCategoryQuery::create()
                ->find();

            foreach ($categories as $category) {
                $productsAmount = ProductCategoryRelQuery::create()->filterByProductCategory($category)->count();
                $category->setProductsAmount($productsAmount);
            }

            return $categories;

//            $categories = ProductCategoryRelQuery::create()
//                ->groupByProductCategoryId()
//                ->rightJoinWith('ProductCategory')
//                ->withColumn('ProductCategory.title', 'category')
//                ->count();


        //               $categories = ProductCategoryRelQuery::create()
        //                    ->groupByProductCategoryId()
        //                    ->rightJoinWith('ProductCategory')
        //                    ->where('ProductCategory.id = ProductCategoryRel.product_category_id')
        //                    ->groupByProductCategoryId()
        //                    ->count();


//            $connection = Propel::getWriteConnection(ProductCategoryTableMap::DATABASE_NAME);
//            $sql = 'SELECT pc.id, pc.title, pc.content, pc.slug, pc.image_id, pc.sortable_rank,
//                    COUNT(*) as products_amount
//                    FROM product_category_rel
//                    JOIN product_category pc ON product_category_rel.product_category_id = pc.id
//                    GROUP BY product_category_id';
//            $stmt = $connection->prepare($sql);
//            $stmt->execute();
//
//            $formatter = new ObjectFormatter();
//            $formatter->setClass(ProductCategory::class);
//            $categories = $formatter->format($connection->getDataFetcher($stmt));

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

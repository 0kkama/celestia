<?php

    namespace App\Service\Catalog;

    use App\Model\Product;
    use App\Model\ProductBrandQuery;
    use App\Model\ProductCategoryQuery;
    use App\Model\ProductPropertyQuery;
    use App\Model\ProductQuery;

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
                ->paginate(1, 3);
//                ->find();
        }

        public function getCategoriesList()
        {
            return ProductCategoryQuery::create()
                    ->join('ProductCategoryRel')
                    ->withColumn('count(*)', 'amount')
                    ->groupBy('ProductCategoryRel.product_category_id')
                    ->find();
        }

        public function getBrandsListByCategoryId($id)
        {
            return ProductBrandQuery::create()
                ->useProductQuery()
                    ->joinWithProductCategoryRel()
                    ->where('ProductCategoryRel.product_category_id = '. 1)
                ->endUse()
                ->joinProduct()
                ->groupBy('ProductBrand.id')
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

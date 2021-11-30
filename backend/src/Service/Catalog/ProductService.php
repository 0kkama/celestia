<?php

    namespace App\Service\Catalog;

    use App\Model\Product;
    use App\Model\ProductBrandQuery;
    use App\Model\ProductCategoryQuery;
    use App\Model\ProductPropertyQuery;
    use App\Model\ProductQuery;
    use Propel\Runtime\ActiveQuery\Criteria;

    class ProductService
    {
        public function getAllProducts()
        {
            return ProductQuery::create()->find();
        }

        public function paginateProductsByCategoryId(int $id, int $page, int $limit, $brand, $title, $priceMin, $priceMax)
        {
            $query =  ProductQuery::create()
                ->leftJoin('ProductRating')
                ->withColumn('avg(ProductRating.rate)', 'product_rate')
                ->useProductCategoryRelQuery()
                    ->filterByProductCategoryId($id)
                ->endUse();

            if (isset($title)) {
                $query->filterBySlug($title, Criteria::EQUAL);
            }

            if (isset($brand)) {
                $query->filterByBrandId($brand);
            }

            if (isset($priceMin)) {
                $query->where("Product.price BETWEEN $priceMin AND $priceMax");
            }

            return $query
                ->groupBy('Product.id')
                ->orderBy('product_rate', Criteria::DESC)
                ->paginate($page, $limit);
        }

        public function getCategoriesList()
        {
            return ProductCategoryQuery::create()
                    ->join('ProductCategoryRel')
                    ->withColumn('count(*)', 'amount')
                    ->groupBy('ProductCategoryRel.product_category_id')
                    ->find();
        }

        public function getBrandsListByCategoryId(int $id)
        {
            return ProductBrandQuery::create()
                ->joinWithProduct()
                ->useProductQuery()
                    ->joinWithProductCategoryRel()
                    ->where('ProductCategoryRel.product_category_id = '. $id)
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

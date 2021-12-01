<?php

    namespace App\Service\Catalog;

    use App\Model\Product;
    use App\Model\ProductBrandQuery;
    use App\Model\ProductCategoryQuery;
    use App\Model\ProductPropertyQuery;
    use App\Model\ProductQuery;
    use App\Model\ProductRating;
    use App\Model\ProductRatingQuery;
    use Propel\Runtime\ActiveQuery\Criteria;

    class ProductService
    {
        public function getAllProducts()
        {
            return ProductQuery::create()->find();
        }

        public function getProductById(int $id): Product
        {
            return ProductQuery::create()
                ->leftJoin('ProductRating')
                ->withColumn('avg(ProductRating.rate)', 'product_rate')
                ->findOneById($id);
        }

        public function paginateProductsByCategoryId(int $id, int $page, int $limit, array $filters)
        {
            $query =  ProductQuery::create()
                ->leftJoin('ProductRating')
                ->withColumn('avg(ProductRating.rate)', 'product_rate')
                ->useProductCategoryRelQuery()
                    ->filterByProductCategoryId($id)
                ->endUse();

            if (isset($filters['productTitle'])) {
                $query->filterBySlug($filters['productTitle'], Criteria::EQUAL);
            }

            if (isset($filters['brand'])) {
                $query->filterByBrandId($filters['brand']);
            }

            return $query
                ->where("Product.price BETWEEN {$filters['minPrice']} AND {$filters['maxPrice']}")
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

        public function hadUserAlreadyVoted($productId, $userId): bool
        {
            $result = ProductRatingQuery::create()
                ->filterByProductId($productId)
                ->filterByUserId($userId)
                ->findOne();

            return !(null === $result);
        }

        public function takeVote($productId, $userId, $rating)
        {
            $voteRow = new ProductRating();
            $voteRow->setProductId($productId)->setUserId($userId)->setRate($rating)->save();
            return true;
        }
    }

<?php

    namespace App\Service\Catalog;

    use App\Helper\ProductParametersDTO;
    use App\Model\Product;
    use App\Model\ProductBrandQuery;
    use App\Model\ProductCategoryQuery;
    use App\Model\ProductPropertyQuery;
    use App\Model\ProductQuery;
    use App\Model\ProductRating;
    use Propel\Runtime\ActiveQuery\Criteria;
    use Propel\Runtime\Collection\ObjectCollection;

    class ProductService
    {
        public function getAllProducts(): ObjectCollection
        {
            return ProductQuery::create()->find();
        }

        public function getProductByUrl(string $url): Product
        {
            return $this->getProductQuery()->findOneBySlug($url);
        }

        public function getProductById(int $id): Product
        {
            return $this->getProductQuery()->findPk($id);
        }

        public function paginateProductsByCategoryId(int $id, ProductParametersDTO $productParameters)
        {
            $query = $this->getProductQuery()
                ->useProductCategoryRelQuery()
                    ->filterByProductCategoryId($id)
                ->endUse();

            if ($productParameters->isTitle()) {
                $query->filterBySlug($productParameters->getProductTitle(), Criteria::EQUAL);
            }

            if ($productParameters->isBrand()) {
                $query->filterByBrandId($productParameters->getBrand(), Criteria::EQUAL);
            }

            return $query
                ->where("Product.price BETWEEN {$productParameters->getMinPrice()} AND {$productParameters->getMaxPrice()}")
                ->groupBy('Product.id')
                ->orderBy('product_rate', Criteria::DESC)
                ->paginate($productParameters->getPage(), $productParameters->getItemsPerPage());
        }

        public function getCategoriesList()
        {
            return ProductCategoryQuery::create()
                    ->join('ProductCategoryRel')
                    ->withColumn('count(*)', 'amount')
                    ->groupBy('ProductCategoryRel.product_category_id')
                    ->find();
        }

        public function getCategoryByUrl(string $slug)
        {
            return ProductCategoryQuery::create()
                ->findBySlug($slug);
        }

        public function getBrandsListByCategory(string $slug)
        {
            return ProductBrandQuery::create()
                ->leftJoinWithProduct()
                ->useProductQuery()
                    ->leftJoinWithProductCategoryRel()
                    ->useProductCategoryRelQuery()
                        ->leftJoinWithProductCategory()
                        ->where("ProductCategory.slug =  '$slug'")
                    ->endUse()
                ->endUse()
                ->groupBy('ProductBrand.id')
                ->find();
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

        public function getProductByPk(int $id)
        {
            return ProductQuery::create()
                ->findPk($id);
        }

        public function takeVote(Product $product, $rating): bool
        {
            $voteRow = new ProductRating();
            $voteRow->setProductId($product->getId())->setRate($rating)->save();
            return true;
        }

        protected function getProductQuery()
        {
            return ProductQuery::create()
                ->leftJoin('ProductRating')
                ->withColumn('avg(ProductRating.rate)', 'product_rate');
        }
    }

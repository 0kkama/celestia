<?php

    namespace App\Normalizer;

    use App\Model\Product;
    use App\Model\ProductCategoryQuery;
    use App\Model\ProductPropertyQuery;

    class ProductNormalizer extends AbstractNormalizer
    {
        public const GROUP_PAGE = 'product_page';
        public const GROUP_LIST = 'products_list';

        public function normalize($object, string $format = null, array $context = [])
        {
            if ($this->hasGroup($context, self::GROUP_PAGE)) {
                $category = ProductCategoryQuery::create()
                    ->useProductCategoryRelQuery()
                        ->filterByProduct($object)
                    ->endUse()
                    ->find();

                $properties = ProductPropertyQuery::create()
                    ->filterByProduct($object)
                    ->find();

                $rating = $object->hasVirtualColumn('product_rate') ?
                    round($object->getVirtualColumn('product_rate'), 0, PHP_ROUND_HALF_UP) : 0;

                $data = [
                    'id' => $object->getId(),
                    'title' => $object->getTitle(),
                    'brand' => [
                        'title' => $object->getProductBrand()->getTitle(),
                        'brand_image' => $object->getProductBrand()->getImage(),
                    ],
                    'price' => $object->getPrice(),
                    'content' => $object->getContent(),
                    'rating' => $rating,
                    'category' => $category,
                    'properties' => $properties,
                    'gallery' => $object->getGallery(),
                    'visible' => $object->getVisible(),
                    'url' => $object->getSlug(),
                ];
            }

            if ($this->hasGroup($context, self::GROUP_LIST)) {

                $properties = ProductPropertyQuery::create()
                    ->filterByProductId($object->getId())
                    ->find();

                $rating = $object->hasVirtualColumn('product_rate') ?
                    round($object->getVirtualColumn('product_rate'), 0, PHP_ROUND_HALF_UP) : 0;

                $data = [
                    'id'         => $object->getId(),
                    'title'      => $object->getTitle(),
                    'image'      => $object->getImage(),
                    'price'      => $object->getPrice(),
                    'brand'      => [
                        'title' => $object->getProductBrand()->getTitle(),
                    ],
                    'rating'     => $rating,
                    'properties' => $properties,
                    'url'        => $object->getSlug(),
                ];
            }

            return $this->serializer->normalize($data, $format, $context);
        }

        public function supportsNormalization($data, string $format = null)
        {
            return $data instanceof Product;
        }
    }





<?php

    namespace App\Normalizer;

    use App\Model\Product;
    use App\Model\ProductCategoryQuery;
    use App\Model\ProductPropertyQuery;

    class ProductNormalizer extends AbstractNormalizer
    {
        public const GROUP_PAGE = 'products_one_product_page';
        public const GROUP_LIST = 'products_list_of_products';

        public function normalize($object, string $format = null, array $context = [])
        {
            $rating = $object->hasVirtualColumn('product_rate') ?
                round($object->getVirtualColumn('product_rate'), 0, PHP_ROUND_HALF_UP) : 0;

            $category = ProductCategoryQuery::create()
                ->useProductCategoryRelQuery()
                ->filterByProduct($object)
                ->endUse()
                ->find();

            $properties = ProductPropertyQuery::create()
                ->filterByProductId($object->getId());

            $data = [
                'id' => $object->getId(),
                'title' => $object->getTitle(),
                'brand' => $object->getProductBrand(),
                'price' => $object->getPrice(),
                'content' => $object->getContent(),
                'rating' => $rating,
                'category' => $category,
            ];

            if ($this->hasGroup($context, self::GROUP_PAGE)) {
//            $properties = $properties->where('ProductProperty.type = 1 OR ProductProperty.type = 3')->find();
                $properties = $properties->find();

                    $data['properties'] = $properties;
                    $data['gallery'] = $object->getGallery();
                    $data['visible'] = $object->getVisible();
                    $data['url'] = $object->getSlug();
            }

            if ($this->hasGroup($context, self::GROUP_LIST)) {
//                $properties = $properties->where('ProductProperty.type = 0 OR ProductProperty.type = 3')->find();
                $properties = $properties->find();

                    $data['properties'] = $properties;
                    $data['url']        = $object->getSlug();
            }

            return $this->serializer->normalize($data, $format, $context);
        }

        public function supportsNormalization($data, string $format = null)
        {
            return $data instanceof Product;
        }
    }





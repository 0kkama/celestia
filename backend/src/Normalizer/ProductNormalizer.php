<?php

    namespace App\Normalizer;

    use App\Model\Product;
    use App\Model\ProductCategoryQuery;
    use App\Model\ProductCategoryRelQuery;
    use App\Model\ProductPropertyQuery;

    class ProductNormalizer extends AbstractNormalizer
    {
        public const GROUP_PAGE = 'product_page';
        public const GROUP_LIST = 'products_list';
        public const GROUP_TEST = 'products_test';

        public function normalize($object, string $format = null, array $context = [])
        {
            if ($this->hasGroup($context, self::GROUP_PAGE)) {
                $data = [
                    'id' => $object->getId(),
                    'title' => $object->getTitle(),
                    'brand' => [
                        'title' => $object->getProductBrand()->getTitle(),
                        'brand_image' => $object->getProductBrand()->getImage(),
                    ],
                    'price' => $object->getPrice(),
                    'content' => $object->getContent(),
                    'rating' => $object->getRating(),
                    'gallery' => $object->getGallery(),
                    'visible' => $object->getVisible(),
                    'url' => $object->getSlug(),
                ];
            }

            if ($this->hasGroup($context, self::GROUP_LIST)) {
                $data = [
                    'id' => $object->getId(),
                    'title' => $object->getTitle(),
                    'image' => $object->getImage(),
                    'price' => $object->getPrice(),
                    'brand' => [
                        'title' => $object->getProductBrand()->getTitle(),
                        ],
                    'properties' => $object,
                    'rating' => $object,
                    'url' => $object->getSlug(),
                    ];
            }

            //            if ($this->hasGroup($context, self::GROUP_TEST)) {
            //            }

            return $this->serializer->normalize($data, $format, $context);
        }


        public function supportsNormalization($data, string $format = null)
        {
            return $data instanceof Product;
        }
    }





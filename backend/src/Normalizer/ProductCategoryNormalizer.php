<?php

    namespace App\Normalizer;

    use App\Model\ProductCategory;

    class ProductCategoryNormalizer extends AbstractNormalizer
    {
        public const GROUP_LIST = 'categories_list';
        public const GROUP_ONE = 'one_category';
        public const GROUP_PRODUCT = 'product_category';

        public function normalize($object, string $format = null, array $context = [])
        {
            if ($this->hasGroup($context, self::GROUP_LIST)) {
                $data = [
                    'id' => $object->getId(),
                    'title' => $object->getTitle(),
                    'slug' => $object->getSlug(),
                    'products_amount' => $object->getVirtualColumn('amount'),
                    'image' => $object->getImage(),
                ];
            }

            if ($this->hasGroup($context, self::GROUP_ONE)) {
                $data = [
                    'id' => $object->getId(),
                    'title' => $object->getTitle(),
                    'content' => $object->getContent(),
                    'slug' => $object->getSlug(),
                    'products_amount' => $object->getProductsAmount(),
                ];
            }

            if ($this->hasGroup($context, self::GROUP_PRODUCT)) {
                $data = [
                    'id' => $object->getId(),
                    'title' => $object->getTitle(),
                    'slug' => $object->getSlug(),
                ];
            }

            return $this->serializer->normalize($data, $format, $context);
        }

        public function supportsNormalization($data, string $format = null)
        {
            return $data instanceof ProductCategory;
        }
    }

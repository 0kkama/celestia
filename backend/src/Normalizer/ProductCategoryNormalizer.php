<?php

    namespace App\Normalizer;

    use App\Model\ProductCategory;

    class ProductCategoryNormalizer extends AbstractNormalizer
    {
        public const GROUP_LIST = 'product_category_list_of_product_categories';
        public const GROUP_ONE = 'product_category_data_for_one_category';
        public const GROUP_PRODUCT = 'product_category_data_for_product_card';

        public function normalize($object, string $format = null, array $context = [])
        {
            $data = [
                'id' => $object->getId(),
                'title' => $object->getTitle(),
                'slug' => $object->getSlug(),
            ];

            if ($this->hasGroup($context, self::GROUP_LIST) || $this->hasGroup($context, self::GROUP_ONE)) {
                $data['products_amount'] = $object->getVirtualColumn('amount');
            }

            if ($this->hasGroup($context, self::GROUP_LIST)) {
                $data['image'] = $object->getImage();
            }

            if ($this->hasGroup($context, self::GROUP_ONE)) {
                $data['content'] = $object->getContent();
            }

            return $this->serializer->normalize($data, $format, $context);
        }

        public function supportsNormalization($data, string $format = null)
        {
            return $data instanceof ProductCategory;
        }
    }

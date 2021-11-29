<?php

    namespace App\Normalizer;

    use App\Model\ProductCategory;

    class ProductCategoryNormalizer extends AbstractNormalizer
    {

        public function normalize($object, string $format = null, array $context = [])
        {
            $data = [
                'id' => $object->getId(),
                'title' => $object->getTitle(),
                'content' => $object->getContent(),
                'slug' => $object->getSlug(),
                'products_amount' => $object->getProductsAmount(),
                'image' => $object->getImage(),
            ];

            return $this->serializer->normalize($data, $format, $context);
        }

        public function supportsNormalization($data, string $format = null)
        {
            return $data instanceof ProductCategory;
        }
    }

<?php

    namespace App\Normalizer;

    use App\Model\ProductProperty;

    class ProductPropertiesNormalizer extends AbstractNormalizer
    {

        public function normalize($object, string $format = null, array $context = [])
        {
            $data = [
                'id' => $object->getId(),
                'product_id' => $object->getProductId(),
                'title' => $object->getTitle(),
                'value' => $object->getValue(),
            ];

            return $this->serializer->normalize($data, $format, $context);
        }

        public function supportsNormalization($data, string $format = null)
        {
            return $data instanceof ProductProperty;
        }
    }

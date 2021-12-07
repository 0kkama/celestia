<?php

    namespace App\Normalizer;

    use App\Model\ProductBrand;

    class ProductBrandNormalizer extends AbstractNormalizer
    {
        public const GROUP_DETAIL = 'product_brand_detail_information';

        public function normalize($object, string $format = null, array $context = [])
        {
            $data = [
                'id'    => $object->getId(),
                'title' => $object->getTitle(),
            ];

            if ($this->hasGroup($context, self::GROUP_DETAIL)) {
                $data['image'] = $object->getImage();
            }
            return $this->serializer->normalize($data, $format, $context);
        }

        public function supportsNormalization($data, string $format = null)
        {
            return $data instanceof ProductBrand;
        }
    }

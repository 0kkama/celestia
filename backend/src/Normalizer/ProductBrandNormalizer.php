<?php

    namespace App\Normalizer;

    use App\Model\ProductBrand;
    use App\Normalizer\AbstractNormalizer;
    use Symfony\Component\Serializer\Exception\CircularReferenceException;
    use Symfony\Component\Serializer\Exception\ExceptionInterface;
    use Symfony\Component\Serializer\Exception\InvalidArgumentException;
    use Symfony\Component\Serializer\Exception\LogicException;

    class ProductBrandNormalizer extends AbstractNormalizer
    {
        public const GROUP_DETAIL = 'brand_detail';
        public const GROUP_LIST = 'brands_list';

        public function normalize($object, string $format = null, array $context = [])
        {
            if ($this->hasGroup($context, self::GROUP_LIST)) {
                $data = [
                    'id'    => $object->getId(),
                    'title' => $object->getTitle(),
                ];
            }

            if ($this->hasGroup($context, self::GROUP_DETAIL)) {
                $data = [
                    'id'    => $object->getId(),
                    'title' => $object->getTitle(),
                    'image' => $object->getImage(),
                ];
            }
            return $this->serializer->normalize($data, $format, $context);
        }

        public function supportsNormalization($data, string $format = null)
        {
            return $data instanceof ProductBrand;
        }
    }

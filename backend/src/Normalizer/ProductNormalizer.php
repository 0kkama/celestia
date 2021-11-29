<?php

    namespace App\Normalizer;

    use App\Model\Product;
    use App\Model\ProductCategoryQuery;
    use App\Model\ProductCategoryRelQuery;
    use App\Model\ProductPropertyQuery;

    class ProductNormalizer extends AbstractNormalizer
    {
        public function normalize($object, string $format = null, array $context = [])
        {
//            $category = ProductCategoryQuery::create()->filterBy($column, $value);
//            $category = ProductCategoryRelQuery::create()->filterByProduct($object)->find();
            $properties = ProductPropertyQuery::create()->filterByProduct($object)->find();

            $data = [
                'id' => $object->getId(),
                'title' => $object->getTitle(),
                'brand' => [
                    'title' => $object->getProductBrand()->getTitle(),
                    'brand_image' => $object->getProductBrand()->getImage(),
                ],
                'price' => $object->getPrice(),
                'content' => $object->getContent(),
//                'category' => $category,
                'properties' => $properties,
                'rating' => $object->getRating(),
                'gallery' => $object->getGallery(),
                'visible' => $object->getVisible(),
                'slug' => $object->getSlug(),
                //                    'properties' => $object->getProductProperties(),
                //                'properties' => $object->getProperties(),
            ];

            return $this->serializer->normalize($data, $format, $context);
        }


        public function supportsNormalization($data, string $format = null)
        {
            return $data instanceof Product;
        }
    }

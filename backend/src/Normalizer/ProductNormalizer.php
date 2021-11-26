<?php

    namespace App\Normalizer;

    use App\Model\Product;

    class ProductNormalizer extends AbstractNormalizer
    {
        public function normalize($object, string $format = null, array $context = [])
        {
//            $category = $object->getProductCategoryRelsJoinProductCategory()->getFirst()->getProductCategory();

            $data = [
                'id' => $object->getId(),
                'title' => $object->getTitle(),
//                'category' => [
//                    'title' => $category->getTitle,
//                    'url' => 'slugmustbehere',
//                    ],
                'brand' => [
                    'title' => $object->getProductBrand()->getTitle(),
                    'brand_image' => $object->getProductBrand()->getImage(),
                ],
                'price' => $object->getPrice(),
                'content' => $object->getContent(),
                'properties' => $object->getProperties(),
                'rating' => $object->getRating(),
                'gallery' => $object->getGallery(),
                'visible' => $object->getVisible(),
                'slug' => $object->getSlug(),
                //                'keywords' => $object->getKeywords(),
                //                'article' => $object->getArticleNumber(),
                //                'description' => $object->getDescription(),
                //                'createdAt' => $object->getCreatedAt(),
                //                'updatedAt' => $object->getUpdatedAt(),
                //                'imageId' => $object->getImage(),
                //                'galleryId' => $object->getImageId(),
            ];

            return $this->serializer->normalize($data, $format, $context);
        }


        public function supportsNormalization($data, string $format = null)
        {
            return $data instanceof Product;
        }
    }

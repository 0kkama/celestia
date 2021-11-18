<?php

    namespace App\Admin\Catalog;

    use Cocur\Slugify\SlugifyInterface;
    use Creonit\AdminBundle\Component\EditorComponent;
    use Creonit\AdminBundle\Component\Request\ComponentRequest;
    use Creonit\AdminBundle\Component\Response\ComponentResponse;

    class ProductEditor extends EditorComponent
    {
//        protected SlugifyInterface $slugify;
//
//        public function __construct(SlugifyInterface $slugify)
//        {
//            $this->slugify = $slugify;
//        }

        /**
         * @title Продукт
         * @entity Product
         *
         * @field title {constraints: [NotBlank()]}
         * @field description {constraints: [NotBlank()]}
         * @field content {constraints: [NotBlank()]}
         * @field price {constraints: [NotBlank()]}
         * @field slug {constraints: [NotBlank()]}
         * @field article_number {constraints: [NotBlank()]}
         * @field brand_id {constraints: [NotBlank()]}
         * @field properties {constraints: [NotBlank()]}
         * @field keywords {constraints: [NotBlank()]}
         *
         * @template
         * {{ title | text | group('Название') }}
         * {{ description | text | group('Краткое описание') }}
         * {{ content | text | group('Полное описание') }}
         * {{ price | text | group('Цена') }}
         * {{ slug | text | group('URL') }}
         * {{ article_number | text | group('Артикул') }}
         * {{ brand_id | text | group('Брэнд') }}
         * {{ properties | text | group('Свойства') }}
         * {{ keywords | text | group('Ключевые слова') }}
         *
         */
        public function schema()
        {
        }

//        public function preSave(ComponentRequest $request, ComponentResponse $response, $entity)
//        {
//            if (!$entity->getSlug()) {
//                $entity->setSlug($this->slugify->slugify($entity->getTitle()));
//            }
//        }
    }

<?php

    namespace App\Admin\Catalog;

    use Creonit\AdminBundle\Component\EditorComponent;

    class ProductBrandEditor extends EditorComponent
    {
        /**
         * @title Бренд
         * @entity ProductBrand
         *
         * @field title {constraints: [NotBlank()]}
         *
         * @template
         * {{ title | text | group('Название') }}
         * {{ image_id | image | group('Изображение') }}
         */
        public function schema()
        {
        }
    }

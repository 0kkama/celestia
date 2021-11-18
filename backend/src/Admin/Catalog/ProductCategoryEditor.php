<?php

    namespace App\Admin\Catalog;

    use Creonit\AdminBundle\Component\EditorComponent;

    class ProductCategoryEditor extends EditorComponent
    {

        /**
         * @title Категория
         * @entity ProductCategory
         *
         * @field title
         * @field image_id
         *
         * {{ title | text | group('Название') }}
         * {{ image_id | text | group('ID изображения') }}
         *
         */
        public function schema()
        {
            // TODO: Implement schema() method.
        }
    }

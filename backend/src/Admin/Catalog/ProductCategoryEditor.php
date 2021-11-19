<?php

    namespace App\Admin\Catalog;

    use Creonit\AdminBundle\Component\EditorComponent;

    class ProductCategoryEditor extends EditorComponent
    {

        /**
         * @entity ProductCategory
         * @title Категория
         *
         * @field title {constraints: [NotBlank()]}
         * @field content {constraints: [NotBlank()]}
         * @field product_amount {constraints: [NotBlank()]}
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

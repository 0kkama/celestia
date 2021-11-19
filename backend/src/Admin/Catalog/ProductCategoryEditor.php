<?php

    namespace App\Admin\Catalog;

    use Creonit\AdminBundle\Component\EditorComponent;

    class ProductCategoryEditor extends EditorComponent
    {

        /**
         * @title Категория
         * @entity ProductCategory
         *
         * @field title {constraints: [NotBlank()]}
         * @field content {constraints: [NotBlank()]}
         *
         * @template
         * {{ title | text | group('Название') }}
         * {{ content | text | group('Описание') }}
         *
         */
        public function schema()
        {
            // TODO: Implement schema() method.
        }
    }

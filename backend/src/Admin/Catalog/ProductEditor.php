<?php

    namespace App\Admin\Catalog;

    use Creonit\AdminBundle\Component\EditorComponent;

    class ProductEditor extends EditorComponent
    {

        /**
         * @title Продукт
         *
         * \Product
         *
         * @field title
         * @field slug
         * @field price
         * @field content
         *
         * @template
         * {{ title | text | group('Название') }}
         * {{ url | text | group('URL') }}
         * {{ price | text | group('Цена') }}
         * {{ content | text | group('Описание') }}
         *
         */
        public function schema()
        {
            // TODO: Implement schema() method.
        }
    }

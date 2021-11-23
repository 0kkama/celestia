<?php

    namespace App\Admin\Catalog;

    use Creonit\AdminBundle\Component\EditorComponent;

    class ProductPropertyEditor extends EditorComponent
    {

        /**
         * @title Свойство товара
         * @entity ProductProperty
         *
         * @field title {constraints: [NotBlank()]}
         *
         * @template
         * {{ title | text | group('Название') }}
         */
        public function schema()
        {
            // TODO: Implement schema() method.
        }
    }

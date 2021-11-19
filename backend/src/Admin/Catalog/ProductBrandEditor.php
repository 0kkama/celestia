<?php

    namespace App\Admin\Catalog;

    use Creonit\AdminBundle\Component\EditorComponent;

    class ProductBrandEditor extends EditorComponent
    {

        /**
         * @title Брэнд
         * @entity ProductBrand
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

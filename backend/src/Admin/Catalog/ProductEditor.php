<?php

    namespace App\Admin\Catalog;

    use Creonit\AdminBundle\Component\EditorComponent;

    class ProductEditor extends EditorComponent
    {

        /**
         * @title Продукт
         * @entity Product
         *
         * @field title type:text {constraints: [NotBlank()]}
         * @field slug type:text {constraints: [NotBlank()]}
         * @field price type:text {constraints: [NotBlank()]}
         * @field description type:textarea {constraints: [NotBlank()]}
         *
         */
        public function schema()
        {
            // TODO: Implement schema() method.
        }
    }

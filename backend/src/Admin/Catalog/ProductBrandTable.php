<?php

    namespace App\Admin\Catalog;

    use Creonit\AdminBundle\Component\TableComponent;

    class ProductBrandTable extends TableComponent
    {

        /**
         * @title Брэнды
         *
         * @header
         * {{ button('Добавить брэнд', {size: 'sm'}) | open('ProductBrandEditor') }}
         *
         * @cols ID, Название, Изображение, .
         *
         * \ProductBrand
         *
         * @col {{ id }}
         * @col {{ title | open('ProductBrandEditor', {key: _key}) }}
         * @col {{ image_id }}
         * @col {{ buttons(_delete()) }}
         */
        public function schema()
        {
            // TODO: Implement schema() method.
        }
    }

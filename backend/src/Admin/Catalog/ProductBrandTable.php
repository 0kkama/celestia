<?php

    namespace App\Admin\Catalog;

    use Creonit\AdminBundle\Component\TableComponent;

    class ProductBrandTable extends TableComponent
    {

        /**
         * @title Брэнд
         *
         * @header
         * {{ button('Добавить категорию', {size: 'sm'}) | open('ProductCategoryEditor') }}
         *
         * @cols ID, Название, Изображение,
         *
         * \ProductBrand
         *
         * @col {{ id }}
         * @col {{ title }}
         * @col {{ image_id }}
         */
        public function schema()
        {
            // TODO: Implement schema() method.
        }
    }

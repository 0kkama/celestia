<?php

    namespace App\Admin\Catalog;

    use Creonit\AdminBundle\Component\TableComponent;

    class ProductCategoryTable extends TableComponent
    {

        /**
         * @title Категории
         *
         * @header {{ button('Добавить категорию', {size: 'sm'}) | open('ProductCategoryEditor') }}
         *
         * @cols ID, Название, Количество товаров, Изображение
         *
         * @entity ProductCategory
         *
         * @col {{ id }}
         * @col {{ title }}
         * @col {{ products_amount }}
         * @col {{ image_id }}
         */
        public function schema()
        {
            // TODO: Implement schema() method.
        }

    }

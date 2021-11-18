<?php

    namespace App\Admin\Catalog;

    use Creonit\AdminBundle\Component\TableComponent;

    class ProductCategoryTable extends TableComponent
    {

        /**
         * @title Категории
         *
         * @header
         * {{ button('Добавить категорию', {size: 'sm'}) | open('ProductCategoryEditor') }}
         *
         * @cols ID, Название, Описание, Количество товаров, Изображение
         *
         * \ProductCategory
         *
         * @col {{ id }}
         * @col {{ title | open('ProductCategoryEditor', {key: _key}) }}
         * @col {{ content }}
         * @col {{ products_amount }}
         * @col {{ image_id }}
         */
        public function schema()
        {
            // TODO: Implement schema() method.
        }

    }

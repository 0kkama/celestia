<?php

    namespace App\Admin\Catalog;

    use Creonit\AdminBundle\Component\TableComponent;

    class ProductCategoryTable extends TableComponent
    {

        /**
         * @title Категории
         * @header
         * {{ button('Добавить категорию', {size: 'sm'}) | open('ProductCategoryEditor') }}
         *
         * @cols ID, Название, Описание, Количество товаров, Изображение, .
         *
         * \ProductCategory
         *
         * @col {{ id }}
         * @col {{ title | controls(buttons(button('', {size: 'xs', icon: 'edit'}) | open('ProductBrandEditor', {key: _key}))) }}
         * @col {{ content }}
         * @col {{ products_amount }}
         * @col {{ image_id }}
         * @col {{ _delete() }}
         */
        public function schema()
        {
        }

    }

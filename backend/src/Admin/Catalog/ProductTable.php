<?php

    namespace App\Admin\Catalog;

    use Creonit\AdminBundle\Component\TableComponent;

    class ProductTable extends TableComponent
    {

        /**
         * @title Продукты
         * @header
         * {{ button('Список категорий', {size: 'sm'}) | open('ProductCategoryTable') }}
         * {{ button('Добавить продукт', {size: 'sm'}) | open('ProductEditor') }}
         *
         * @cols Название, URL, Цена, Описание, Дата
         *
         * @entity Product
         *
         * @col {{ title }}
         * @col {{ slug }}
         * @col {{ price }}
         * @col {{ description }}
         * @col {{ created_at }}
         *
         * @pagination
         */
        public function schema()
        {
            // TODO: Implement schema() method.
        }
    }

<?php

    namespace App\Admin\Catalog;

    use Creonit\AdminBundle\Component\TableComponent;

    class ProductBrandTable extends TableComponent
    {
        /**
         * @title Бренды
         *
         * @header
         * {{ button('Добавить бренд', {size: 'sm'}) | open('ProductBrandEditor') }}
         *
         * @cols ID, Название, Изображение, .
         *
         * \ProductBrand
         *
         * @col {{ id }}
         * @col {{ title | controls(buttons(button('', {size: 'xs', icon: 'edit'}) | open('ProductBrandEditor', {key: _key}))) }}
         * @col {{ image_id }}
         * @col {{ _delete() }}
         */
        public function schema()
        {
        }
    }

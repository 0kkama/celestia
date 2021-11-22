<?php

    namespace App\Admin\Catalog;

    use Creonit\AdminBundle\Component\TableComponent;

    class ChooseProductBrand extends TableComponent
    {
        /**
         * @title Выберите бренд
         *
         * \ProductBrand
         *
         *
         * \ProductBrand
         * @col {{ id }}
         * @col {{ title | controls(buttons(button('', {size: 'xs', icon: 'edit'}) | open('ProductBrandEditor', {key: _key}))) }}
         * @col {{ image_id }}
         *
         * @col
         * {{ title | action('external', _key) | controls }}
         *
         */
        public function schema()
        {
        }
    }

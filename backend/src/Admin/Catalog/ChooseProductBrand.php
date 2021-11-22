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
         * <div class="pull-right">
         *   <div class="label label-default">{{ title }}</div>
         * </div>
         * <strong>
         *   {{ title | icon('globe') | action('external', _key) | controls }}
         * </strong>
         *
         * \ProductBrand
         * @col {{ id }}
         * @col {{ title | controls(buttons(button('', {size: 'xs', icon: 'edit'}) | open('ProductBrandEditor', {key: _key}))) }}
         * @col {{ image_id }}
         *
         * @col
         * {{ title | icon(icon) | action('external', _key) | controls }}
         *
         */
        public function schema()
        {
        }
    }

<?php

    namespace App\Admin\Catalog;

    use Creonit\AdminBundle\Component\TableComponent;

    class ProductPropertyTable extends TableComponent
    {

        /**
         * @title Свойства
         *
         * @header
         * {{ button('Добавить свойство', {size: 'sm'}) | open('ProductPropertyEditor') }}
         *
         * @cols ID, Название, .
         *
         * \ProductProperty
         *
         * @col {{ id }}
         * @col {{ title | controls(buttons(button('', {size: 'xs', icon: 'edit'}) | open('ProductPropertyEditor', {key: _key}))) }}
         * @col {{ _delete() }}
         */
        public function schema()
        {
        }
    }
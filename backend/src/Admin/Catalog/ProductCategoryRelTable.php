<?php

    namespace App\Admin\Catalog;

    use Creonit\AdminBundle\Component\TableComponent;

    class ProductCategoryRelTable extends TableComponent
    {

        /**
         * @header
         * @header {{ button('Список категорий, {size: 'sm'}) | open('ProductCategoryTable') }}
         *
         * @cols
         *
         * @entity ProductCategoryRel
         * @field title
         * @field product_category_id
         *
         * @col {{ title }}
         */
        public function schema()
        {
        }
    }


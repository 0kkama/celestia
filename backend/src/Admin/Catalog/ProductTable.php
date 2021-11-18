<?php

    namespace App\Admin\Catalog;

    use Creonit\AdminBundle\Component\Request\ComponentRequest;
    use Creonit\AdminBundle\Component\Response\ComponentResponse;
    use Creonit\AdminBundle\Component\Scope\Scope;
    use Creonit\AdminBundle\Component\TableComponent;
    use Symfony\Component\HttpFoundation\ParameterBag;

    class ProductTable extends TableComponent
    {

        /**
         * @title Продукты
         * @header
         * {{ button('Список категорий', {size: 'sm'}) | open('ProductCategoryTable') }}
         * {{ button('Добавить продукт', {size: 'sm'}) | open('ProductEditor') }}
         *
         * @cols Название, URL, Цена, Описание, Свойства, Рейтинг, Дата
         *
         * \Product
         *
         * @col {{ title }}
         * @col {{ slug }}
         * @col {{ price }}
         * @col {{ content }}
         * @col {{ properties }}
         * @col {{ rating }}
         * @col {{ created_at | date("d-m-Y")}}
         *
         * @pagination
         */
        public function schema()
        {
            // TODO: Implement schema() method.
        }
    }

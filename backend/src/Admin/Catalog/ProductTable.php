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
         * <form class="form-inline pull-right">
         * {{ search | text({placeholder: 'Поиск', size: 'sm'}) | group('Поиск') }}
         * {{ submit('Обновить', {size: 'sm'}) }}
         * </form>
         *
         * @cols ID, Название, URL, Цена, Описание, Свойства, Рейтинг
         *
         * \Product
         *
         * @col {{ id }}
         * @col {{ title | open('ProductEditor', {id: id})}}
         * @col {{ slug }}
         * @col {{ price }}
         * @col {{ content }}
         * @col {{ properties }}
         * @col {{ rating }}
         *
         */
        public function schema()
        {
        }
    }

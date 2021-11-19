<?php

    namespace App\Admin\Catalog;

    use App\Model\ProductBrandQuery;
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
         * @cols ID, Название, URL, Цена, Описание, Резюме, Свойства, Рейтинг, Брэнд, Артикул, .
         *
         * \Product
         *
         * @col {{ id }}
         * @col {{ title | open('ProductEditor', {key: _key}) }}
         * @col {{ slug }}
         * @col {{ price }}
         * @col {{ content }}
         * @col {{ description }}
         * @col {{ properties }}
         * @col {{ rating }}
         * @col {{ brand_id }}
         * @col {{ article_number }}
         * @col {{ buttons(_visible()~_delete()) }}
         *
         * @sortable
         *
         * @pagination 5
         *
         */
        public function schema()
        {
        }
    }

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
         * {{ button('Список категорий', {size: 'sm', icon: 'bars', type: 'primary'}) | open('ProductCategoryTable') }}
         * {{ button('Список брендов', {size: 'sm', icon: 'flag', type: 'info'}) | open('ProductBrandTable') }}
         * {{ button('Добавить продукт', {size: 'sm' , icon: 'bomb', type: 'success'}) | open('ProductEditor') }}
         * {{ button('Фильтровать по: ', {size: 'sm', icon: 'bars', type: 'primary'}) | checkbox('') }}
         *
         *
         * <form class="form-inline pull-right">
         * {{ search | text({placeholder: 'Название', size: 'sm'}) | group('Поиск') }}
         * {{ submit('Обновить', {size: 'sm'}) }}
         * </form>
         *
         * @cols ID, Название, URL, Цена, Описание, Резюме, Свойства, Рейтинг, Бренд, Артикул, Категория, .
         *
         * \Product
         * @col {{ id }}
         * @col {{ title | controls(buttons(button('', {size: 'xs', icon: 'edit'}) | open('ProductEditor', {key: _key}))) }}
         * @col {{ slug }}
         * @col {{ price }}
         * @col {{ content }}
         * @col {{ description }}
         * @col {{ properties }}
         * @col {{ rating }}
         * @col {{ brand }}
         * @col {{ article_number }}
         * @col {{ category }}
         * @col {{ buttons(_visible()~_delete()) }}
         *
         * @sortable true
         * @pagination 5
         *
         */
        public function schema()
        {
        }

        protected function decorate(ComponentRequest $request, ComponentResponse $response, ParameterBag $data, $entity, Scope $scope, $relation, $relationValue, $level)
        {
            $data->set('brand', $entity->getProductBrand()->getTitle());

            $category = $entity->getProductCategoryRelsJoinProductCategory()
                ->getFirst()
                ->getProductCategory()
                ->getTitle();
            $data->set('category', $category);
        }
    }

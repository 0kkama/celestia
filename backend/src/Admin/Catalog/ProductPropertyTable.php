<?php

    namespace App\Admin\Catalog;

    use App\Model\ProductPropertyQuery;
    use App\Model\ProductQuery;
    use Creonit\AdminBundle\Component\Request\ComponentRequest;
    use Creonit\AdminBundle\Component\Response\ComponentResponse;
    use Creonit\AdminBundle\Component\Scope\Scope;
    use Creonit\AdminBundle\Component\TableComponent;
    use Symfony\Component\HttpFoundation\ParameterBag;


    class ProductPropertyTable extends TableComponent
    {

        /**
         * @title Свойства
         * @header
         * {{ button('Добавить свойство', {size: 'sm'}) | open('ProductPropertyEditor') }}
         *
         * @cols ID, Название, Значение, .
         *
         * \ProductProperty
         *
         * @col {{ id }}

         * @col {{ title | controls(buttons(button('', {size: 'xs', icon: 'edit'}) | open('ProductPropertyEditor', {key: _key, product_id: _query.product_id}))) }}
         * @col {{ value }}
         * @col {{ _delete() }}
         */
        public function schema()
        {
        }

        protected function filter(ComponentRequest $request, ComponentResponse $response, $query, Scope $scope, $relation, $relationValue, $level)
        {
            $query->filterByProductId($request->query->get('product_id'));
        }
    }

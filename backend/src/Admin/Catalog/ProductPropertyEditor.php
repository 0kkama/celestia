<?php

    namespace App\Admin\Catalog;

    use Creonit\AdminBundle\Component\EditorComponent;
    use Creonit\AdminBundle\Component\Request\ComponentRequest;
    use Creonit\AdminBundle\Component\Response\ComponentResponse;

    class ProductPropertyEditor extends EditorComponent
    {

        /**
         * @title Свойство товара
         * @entity ProductProperty
         *
         * @field title {constraints: [NotBlank()]}
         * @field value {constraints: [NotBlank()]}
         *
         * @template
         *
         * {{ title | text | group('Название') }}
         * {{ value | text | group('Значение') }}
         */
        public function schema()
        {
        }

        public function preSave(ComponentRequest $request, ComponentResponse $response, $entity)
        {
           $entity->setProductId($request->data->get('product_id'));
        }
    }

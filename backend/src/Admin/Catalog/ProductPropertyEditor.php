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
         * @field product_id
         *
         * @template
         *
         * {{ title | text | group('Название') }}
         * {{ value | text | group('Значение') }}
         * {{ product_id | text({placeholder: 'Будет сформирован автоматически'}) | group('ID продукта')}}
         */
        public function schema()
        {
        }

        public function preSave(ComponentRequest $request, ComponentResponse $response, $entity)
        {
            if($entity->isNew()) {
                $entity->setProductId($request->query->get('product_id'));
            }
        }
    }

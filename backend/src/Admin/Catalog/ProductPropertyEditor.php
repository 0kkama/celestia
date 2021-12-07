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
         * @field type
         *
         * @template
         *
         * {{ title | text | group('Название') }}
         * {{ value | text | group('Значение') }}
         * {{ product_id | text({placeholder: 'Будет сформирован автоматически'}) | group('ID продукта')}}
         *
         * <div class="form-check">
         *      <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" checked>
         *       <label class="form-check-label" for="flexRadioDefault1">
         *           Свойсто доступно и в карточке и в списке
         *       </label>
         *   </div>
         *   <div class="form-check">
         *       <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2">
         *       <label class="form-check-label" for="flexRadioDefault2">
         *           Свойство доступно только в списке продуктов
         *       </label>
         *   </div>
         *  <div class="form-check">
         *       <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2">
         *       <label class="form-check-label" for="flexRadioDefault2">
         *           Свойство доступно только в карточке продукта
         *       </label>
         *   </div>
         *
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

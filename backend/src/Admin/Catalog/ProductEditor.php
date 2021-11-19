<?php

    namespace App\Admin\Catalog;

    use App\Model\Product;
    use Cocur\Slugify\SlugifyInterface;
    use Creonit\AdminBundle\Component\EditorComponent;
    use Creonit\AdminBundle\Component\Request\ComponentRequest;
    use Creonit\AdminBundle\Component\Response\ComponentResponse;

    class ProductEditor extends EditorComponent
    {
        protected SlugifyInterface $slugify;

        public function __construct(SlugifyInterface $slugify)
        {
            $this->slugify = $slugify;
        }

        /**
         * @title Продукт
         * @entity Product
         *
         * @field title {constraints: [NotBlank()]}
         * @field description {constraints: [NotBlank()]}
         * @field content {constraints: [NotBlank()]}
         * @field price {constraints: [NotBlank()]}
         * @field article_number {constraints: [NotBlank()]}
         * @field brand_id: external {title:'entity.get
         * @field properties {constraints: [NotBlank()]}
         * @field keywords {constraints: [NotBlank()]}
         *
         * @template
         * {{ title | text | group('Название') }}
         * {{ description | text | group('Краткое описание') }}
         * {{ content | text | group('Полное описание') }}
         * {{ price | text | group('Цена') }}
         * {{ slug | text({placeholder: 'Будет сформирован из названия'}) | group('URL') }}
         * {{ article_number | text | group('Артикул') }}
         * {{ brand_id | external('BrandTable', { query: { }}) | group('Выбрать Брэнд') }}
         * {{ properties | text | group('Свойства') }}
         * {{ keywords | text | group('Ключевые слова') }}
         *
         */
        public function schema()
        {
        }
        /**
         * @param ComponentRequest $request
         * @param ComponentResponse $response
         * @param Product $entity
         */
        public function preSave(ComponentRequest $request, ComponentResponse $response, $entity)
        {
            if (!$entity->getSlug()) {
                $entity->setSlug($this->slugify->slugify($entity->getTitle()));
            }
        }
    }

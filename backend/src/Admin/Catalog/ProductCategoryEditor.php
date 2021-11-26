<?php

    namespace App\Admin\Catalog;

    use App\Model\ProductCategory;
    use Cocur\Slugify\SlugifyInterface;
    use Creonit\AdminBundle\Component\EditorComponent;
    use Creonit\AdminBundle\Component\Request\ComponentRequest;
    use Creonit\AdminBundle\Component\Response\ComponentResponse;

    class ProductCategoryEditor extends EditorComponent
    {
        protected SlugifyInterface $slugify;

        public function __construct(SlugifyInterface $slugify)
        {
            $this->slugify = $slugify;
        }
        /**
         * @title Категория
         * @entity ProductCategory
         *
         * @field title {constraints: [NotBlank()]}
         * @field content {constraints: [NotBlank()]}
         *
         * @template
         * {{ title | text | group('Название') }}
         * {{ content | text | group('Описание') }}
         *  {{ slug | text({placeholder: 'Будет сформирован из названия'}) | group('URL') }}
         *  {{ image_id | image | group('Изображение') }}
         */
        public function schema()
        {
        }

        /**
         * @param ComponentRequest $request
         * @param ComponentResponse $response
         * @param ProductCategory $entity
         */
        public function preSave(ComponentRequest $request, ComponentResponse $response, $entity)
        {
            if (!$entity->getSlug()) {
                $entity->setSlug($this->slugify->slugify($entity->getTitle()));
            }
        }
    }

<?php

    namespace App\Admin\Catalog;

    use Cocur\Slugify\SlugifyInterface;
    use Creonit\AdminBundle\Component\EditorComponent;
    use Creonit\AdminBundle\Component\Request\ComponentRequest;
    use Creonit\AdminBundle\Component\Response\ComponentResponse;

    class ProductBrandEditor extends EditorComponent
    {
        protected SlugifyInterface $slugify;

        public function __construct(SlugifyInterface $slugify)
        {
            $this->slugify = $slugify;
        }

        /**
         * @title Бренд
         * @entity ProductBrand
         *
         * @field title {constraints: [NotBlank()]}
         * @field slug
         * @field product_id
         *
         * @template
         * {{ title | text | group('Название') }}
         * {{ slug | text({placeholder: 'Будет сформирован из названия'}) | group('URL') }}
         * {{ image_id | image | group('Изображение') }}
         */
        public function schema()
        {
        }

        public function preSave(ComponentRequest $request, ComponentResponse $response, $entity)
        {
            if (!$entity->getSlug()) {
                $entity->setSlug($this->slugify->slugify($entity->getTitle()));
            }
        }
    }

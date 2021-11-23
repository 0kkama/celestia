<?php

    namespace App\Admin\Catalog;

    use App\Model\Product;
    use App\Model\ProductBrandQuery;
    use App\Model\ProductCategoryQuery;
    use App\Model\ProductCategoryRel;
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
         * @field slug
         * @field article_number {constraints: [NotBlank()]}
         * @field brand_id:select
         * @field category_id:select
         * @field properties {constraints: [NotBlank()]}
         * @field keywords {constraints: [NotBlank()]}
         *
         * @template
         * {{ title | text | group('Название') }}
         * {{ description | text | group('Краткое описание') }}
         * {{ content | textarea | group('Полное описание') }}
         * {{ price | text | group('Цена') }}
         * {{ slug | text({placeholder: 'Будет сформирован из названия'}) | group('URL') }}
         * {{ article_number | text | group('Артикул') }}
         * {{ brand_id | select | group('Выбрать бренд')}}
         * {{ category_id | select | group('Выбрать категорию') }}
         * {{ component('ProductPropertyTable', {product_id: _key}) | group('Свойства') }}
         * {{ keywords | text | group('Ключевые слова') }}
         * {{ gallery_id | gallery | group('Добавить изображения') }}
         *
         */
        public function schema()
        {
            $brands = ProductBrandQuery::create()->find();
            $brandsList = [];
            foreach ($brands as $brand) {
                $brandsList[$brand->getId()] = $brand->getTitle();
            }
            $this->getField('brand_id')->setOptions($brandsList);

            $categories = ProductCategoryQuery::create()->find();
            $categoriesList = [];
            foreach ($categories as $category) {
                $categoriesList[$category->getId()] = $category->getTitle();
            }
            $this->getField('category_id')->setOptions($categoriesList);
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

        public function postSave(ComponentRequest $request, ComponentResponse $response, $entity)
        {
            $catId = $request->data->get('category_id');

            $category = ProductCategoryQuery::create()->findOneById($catId);
            $amount = $category->getProductsAmount();
            $category->setProductsAmount($amount + 1)->save();

            (new ProductCategoryRel())
                ->setProductId($entity->getId())
                ->setProductCategoryId($catId)
                ->save();
        }
    }

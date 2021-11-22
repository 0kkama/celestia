<?php

    namespace App\Admin\Catalog;

    use App\Admin\ExtraAdminModule;

    class CatalogModule extends ExtraAdminModule
    {
        protected function configure(): void
        {
            $this
                ->setTitle('Каталог')
                ->setIcon('newspaper-o')
                ->setTemplate('ProductTable');
        }

        public function initialize(): void
        {
            $this->addComponentAsService(ProductTable::class);
            $this->addComponentAsService(ProductEditor::class);
            $this->addComponentAsService(ProductCategoryTable::class);
            $this->addComponentAsService(ProductCategoryEditor::class);
            $this->addComponentAsService(ProductCategoryRelTable::class);
            $this->addComponentAsService(ProductBrandTable::class);
            $this->addComponentAsService(ProductBrandEditor::class);
            $this->addComponentAsService(ChooseProductBrand::class);
            $this->addComponentAsService(ChooseProductCategory::class);
        }
    }

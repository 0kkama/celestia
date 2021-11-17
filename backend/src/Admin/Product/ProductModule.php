<?php

    namespace App\Admin\Product;

    use App\Admin\ExtraAdminModule;

    class ProductModule extends ExtraAdminModule
    {
        protected function configure(): void
        {
            $this
                ->setTitle('Товары')
                ->setIcon('box')
                ->setTemplate('ProductTable');
        }

        public function initialize(): void
        {
            $this->addComponentAsService('classname');
            $this->addComponentAsService('classname');
            $this->addComponentAsService('classname');
            $this->addComponentAsService('classname');
        }
    }

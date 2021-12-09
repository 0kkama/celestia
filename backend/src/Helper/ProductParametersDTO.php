<?php

    namespace App\Helper;

    class ProductParametersDTO
    {
        protected $page;
        protected $productTitle;
        protected $brand;
        protected $minPrice;
        protected $maxPrice;
        protected $itemsPerPage;

        /**
         * @return mixed
         */
        public function getItemsPerPage()
        {
            return $this->itemsPerPage;
        }

        /**
         * @param mixed $itemsPerPage
         * @return ProductParametersDTO
         */
        public function setItemsPerPage($itemsPerPage)
        {
            $this->itemsPerPage = $itemsPerPage;
            return $this;
        }

        /**
         * @return mixed
         */
        public function getPage()
        {
            return $this->page;
        }

        /**
         * @param mixed $page
         * @return ProductParametersDTO
         */
        public function setPage($page)
        {
            $this->page = $page;
            return $this;
        }

        /**
         * @return mixed
         */
        public function getProductTitle()
        {
            return $this->productTitle;
        }

        /**
         * @param mixed $productTitle
         * @return ProductParametersDTO
         */
        public function setProductTitle($productTitle)
        {
            $this->productTitle = $productTitle;
            return $this;
        }

        /**
         * @return mixed
         */
        public function getBrand()
        {
            return $this->brand;
        }

        /**
         * @param mixed $brand
         * @return ProductParametersDTO
         */
        public function setBrand($brand)
        {
            $this->brand = $brand;
            return $this;
        }

        /**
         * @return mixed
         */
        public function getMinPrice()
        {
            return $this->minPrice;
        }

        /**
         * @param mixed $minPrice
         * @return ProductParametersDTO
         */
        public function setMinPrice($minPrice)
        {
            $this->minPrice = $minPrice;
            return $this;
        }

        /**
         * @return mixed
         */
        public function getMaxPrice()
        {
            return $this->maxPrice;
        }

        /**
         * @param mixed $maxPrice
         * @return ProductParametersDTO
         */
        public function setMaxPrice($maxPrice)
        {
            $this->maxPrice = $maxPrice;
            return $this;
        }

        public function isTitle(): bool
        {
            return isset($this->productTitle);
        }

        public function isBrand(): bool
        {
            return isset($this->brand);
        }
    }

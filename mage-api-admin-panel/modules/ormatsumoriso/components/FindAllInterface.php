<?php

namespace modules\ormatsumoriso\components;


interface FindAllInterface
{
        /**
         * Gets number of records
         *
         * @return mixed
         */
        public function findAllAndCount();

}
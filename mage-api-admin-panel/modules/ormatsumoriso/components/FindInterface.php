<?php

namespace modules\ormatsumoriso\components;


interface FindInterface
{
        /**
         * Gets number of records
         *
         * @return mixed
         */
        public function findAllAndCount();

}
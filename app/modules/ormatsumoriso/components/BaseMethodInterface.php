<?php

namespace modules\ormatsumoriso\components;


interface BaseMethodInterface
{
    /**
     * Get all records
     *
     * @return mixed
     */
    public function findAll();

    /**
     * Get record by parameter and value
     *
     * @param $param
     * @param $value
     *
     * @return mixed
     */
    public function findByParam($param, $value);
}
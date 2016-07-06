<?php

namespace modules\ormatsumoriso\components;


interface FindParamInterface
{
    /**
     * Gets record by parameter and value
     *
     * @param $param
     * @param $value
     *
     * @return mixed
     */
    public function findByParam($param, $value);
}
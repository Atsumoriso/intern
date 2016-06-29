<?php

namespace ormatsumoriso\components;


interface BaseMethodInterface
{
    public function findAll();

    public function findById($id);

    public function findByParam();
}
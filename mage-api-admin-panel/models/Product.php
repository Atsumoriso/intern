<?php

namespace models;

use modules\ormatsumoriso\EntityCommonModelAbstract;
use modules\ormatsumoriso\components\EntityInterface;
use modules\ormatsumoriso\components\FindInterface;

/**
 * Product Model
 * Class to work with table product.
 *
 * @package Entity
 */
class Product extends EntityCommonModelAbstract
    implements EntityInterface,
               FindInterface
{

    const STATUS_NOT_ACTIVE = 0;
    const STATUS_ACTIVE = 1;

    const API_REST_PRODUCTS_URL = '/api/rest/products';

    /**
     * @inheritdoc
     */
    public function getTableName()
    {
        return 'product';
    }

    public function saveData($data)
    {
        $product = new Product($this->_connection);
        $this->_setData($product, $data);
    }


    /**
     *
     * @param $data
     * @param $id
     */
    public function updateData($data, $id)
    {
        $product = new Product($this->_connection);
        $product->load($id);
        $this->_setData($product, $data);
    }

    /**
     * Sets data to product.
     * @param $product
     * @param $data
     */
    protected function _setData($product, $data)
    {
        $product->setEntityId($data->entity_id);
        $product->setSku($data->sku);
        $product->setDescription($data->description);
        $product->setName($data->name);
        $product->setPrice($data->final_price_with_tax);
        $product->setIsSaleable($data->is_saleable);
        $product->setStatus(Product::STATUS_ACTIVE);
        $product->setImageUrl($data->image_url);

        $product->save();
    }


    /**
     * Converts productsList object to array of objects
     *
     * @param $obj
     * @return array     array of objects
     */
    public static function object_to_array($obj) {
        if(is_object($obj)) $obj = (array) $obj;
        return $obj;

//        if(is_array($obj)) {
//            $new = array();
//            foreach($obj as $key => $val) {
//                $new[$key] = self::object_to_array($val);
//            }
//        }
//        else $new = $obj;
//        return $new;
    }

    /**
     * Finds all products with sorting parameters.
     *
     * @param $sort               - sorting parameter (price or name)
     * @param $direction          - sorting direction - ASC or DESC
     * @param $currentPage        - current page to display
     * @param $offset             - number of items to display on one page
     * @return mixed
     */
    public function findAllAndSortByParam($sort, $direction, $currentPage, $offset)
    {
        //from what record we should get data and display
        $limit = ($currentPage * $offset)-$offset;

        if($sort === 'price') $order = 6; //price column number
        if($sort === 'name') $order = 5;  //name  column number
        if($direction == 'asc'){
            $query = "
            SELECT * 
            FROM "
                . $this->getTableName() . "
            ORDER BY 
            :order   
            ASC             
            LIMIT  :limit ,
             :offset" ;
        } elseif ($direction == 'desc'){
            $query = "
            SELECT * 
            FROM "
                . $this->getTableName() . "
            ORDER BY 
            :order   
            DESC 
            LIMIT  :limit ,
             :offset";
        }

        $stmt = $this->_connection->prepare($query);
        $stmt->bindParam(":order",$order, \PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetchAll(\PDO::FETCH_OBJ); //массив объектов
        return $res;
    }

    /**
     * Checks if record exists.
     *
     * @param $sku
     * @return mixed
     */
    public function checkBySkuIfRecordExists($sku)
    {
            $query = "
            SELECT * 
            FROM "
                . $this->getTableName() . "
            WHERE `sku` = :sku";

        $stmt = $this->_connection->prepare($query);
        $stmt->bindParam(":sku",$sku);
        $stmt->execute();
        $res = $stmt->fetch();
        return $res;

    }

    public function checkByIdIfRecordExists($id)
    {
        $query = "
            SELECT * 
            FROM "
            . $this->getTableName() . "
            WHERE `id` = :id";

        $stmt = $this->_connection->prepare($query);
        $stmt->bindParam(":id",$id);
        $stmt->execute();
        $res = $stmt->fetch();
        return $res;
    }


}
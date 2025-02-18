<?php

namespace Appy\Src\Core;
use Exception;

abstract class BaseRepository{

    protected $table;
    protected $champs;

    public function findBy(array $criteria, array $orderBy = null, array $limit = null, array $offset = null){
        try {
            $sql   = "SELECT * FROM " .$this->table . " WHERE ";
            $count = 0;
            $total = count($criteria);
            foreach ($criteria as $key => $value) {
                $sql .= $key . " = " . $value;
                if ($count < $total - 1) {
                    $sql .= " AND ";
                }
                $count++;
            }
            if($orderBy != null){
                $count = 0;
                $total = count($orderBy);
                $sql .= " ORDER BY ";
                foreach ($orderBy as $key => $value) {
                    $sql .= $key . " " . $value;
                    if ($count < $total - 1) {
                        $sql .= ", ";
                    }
                    $count++;
                }
            }
            $datas = ConnexionBDD::query($sql)->fetchAll(\PDO::FETCH_ASSOC);
            $entityData = $this->arrayToEntity($datas);
            return  $entityData;
        } catch (\Exception $e) {
            throw new \Exception("<strong>Erreur dans la fonction \"".__FUNCTION__."\" de la classe \"".__CLASS__."\" ! :</strong><br/>".$e->getMessage());
        }
    }

    public function findOneBy(array $criteria){
        try{
            $sql   = "SELECT * FROM " .$this->table . " WHERE ";
            $count = 0;
            $total = count($criteria);
            foreach ($criteria as $key => $value) {
                $sql .= $key . " = '" . $value . "'";
                if ($count < $total - 1) {
                    $sql .= " AND ";
                }
                $count++;
            }
            $datas = ConnexionBDD::query($sql)->fetchAll(\PDO::FETCH_ASSOC);
            if(count($datas) > 1){
                throw new Exception("La requete retourne plusieurs éléments");
            }
            $entityData = $this->arrayToEntity($datas);
            return  $entityData;
        }catch (\Exception $e) {
            throw new \Exception("<strong>Erreur dans la fonction \"".__FUNCTION__."\" de la classe \"".__CLASS__."\" ! :</strong><br/>".$e->getMessage());
        }
    }

    public function findAll(array $orderBy = null){
        try{
            $sql = "SELECT * FROM " . $this->table;
            if($orderBy != null){
                $count = 0;
                $total = count($orderBy);
                $sql .= " ORDER BY ";
                foreach ($orderBy as $key => $value) {
                    $sql .= $key . " " . $value;
                    if ($count < $total - 1) {
                        $sql .= ", ";
                    }
                    $count++;
                }
            }
            $datas = ConnexionBDD::query($sql)->fetchAll(\PDO::FETCH_ASSOC);
            $entityData = $this->arrayToEntity($datas);
            return  $entityData;
        }catch (\Exception $e) {
            throw new \Exception("<strong>Erreur dans la fonction \"".__FUNCTION__."\" de la classe \"".__CLASS__."\" ! :</strong><br/>".$e->getMessage());
        }
    }

    public function insert($entity)
    {
        $entityArray = get_object_vars($entity);

        $sql = "INSERT INTO " . $this->table . " (";
        $sql .= implode(",", $this->champs) . ") VALUES (";
        $count = 0;
        $total = count($this->champs);
        foreach ($this->champs as $key => $value) {
            $sql .= ":". str_replace("`", "", $value);
            if ($count < $total - 1) {
                $sql .= ", ";
            }
            $count++;
        }
        $sql .= ");";

        $count = 0;
        $total = count($entityArray);
        $params = array();
        foreach ($entityArray as $key => $value) {
            $params[":". str_replace("`", "", $this->champs[$count])] = $value;
            $count++;
        }
        ConnexionBDD::query($sql, $params);
    }

    public function update($entity){
        $entityArray = get_object_vars($entity);

        $sql = "UPDATE ". $this->table . " SET ";
        $count = 0;
        $total = count($this->champs);
        foreach ($this->champs as $key => $value) {
            $sql .= $value . " = ";
            $sql .= ":".str_replace("`", "", $value);
            if ($count < $total - 1) {
                $sql .= ", ";
            }
            $count++;
        }

        $count = 0;
        $total = count($entityArray);
        $params = array();
        foreach ($entityArray as $key => $value) {
            $params[":". str_replace("`", "", $this->champs[$count])] = $value;
            $count++;
        }
        foreach ($entityArray as $key => $value) {
            $sql .= "  WHERE " . $this->champs[0] . " = " . $entityArray[$key];
            break;
        }
        ConnexionBDD::query($sql,$params);
    }

    public function delete($entity){
        $sql = "DELETE FROM " . $this->table . " WHERE id=" . $entity->id;
        ConnexionBDD::query($sql);
    }

    abstract protected function arrayToEntity(array $data);

}
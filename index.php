<?php

interface CreatingRepository {
    function create($entity);
}
interface  UpdatingRepository {
    function deleteById($id);
    function update($id, $entity);
}
interface QueryingRepository {
    function count();
    function findAll();
    function findById($id);
}
interface CrudRepository extends CreatingRepository, UpdatingRepository, QueryingRepository {

}
class UserRepository implements CrudRepository{

    private $content = [];

    function count(){
        return count($this->content);
    }

    function deleteById($id){
        if ($this->contains($id)) {
            unset($this->content[$id]);
            echo "Deleted '$id' index" . PHP_EOL;
        }
    }

    function findAll(){
         return $this->content;
    }

    function findById($id){
        if ($this->contains($id)) {
            echo "Found elem with '$id'" . PHP_EOL;
            return $this->content[$id];
        }
    }

    function update($id,$entity){
        if ($this->contains($id)){
            $this->content[$id] = $entity;
            echo "Updated '$id' with '$entity'" . PHP_EOL;
        }
    }

    function create($entity){
        $this->content[] = $entity;
        end($this->content);
        echo "Inserted index was " . key($this->content) . PHP_EOL;
    }

    private function contains($id) {
        return array_key_exists($id, $this->content);
    }

 }

class TransactionRepository implements CreatingRepository, QueryingRepository{

    private $content = [];

    function count(){
        return count($this->content);
    }

/*    function deleteById($id){
        throw new UnsupportedOperationException("Transactions cant be deleted.");
    }*/

    function findAll(){
        return $this->content;
    }

    function findById($id){
        if ($this->contains($id)) {
            echo "Found elem with '$id'" . PHP_EOL;
            return $this->content[$id];
        }
    }

 /*   function update($id,$entity){
        throw new UnsupportedOperationException("Transactions cant be updated.");
    }*/

    function create($entity){
        $this->content[] = $entity;
        end($this->content);
        echo "Inserted index was " . key($this->content) . PHP_EOL;
    }

    private function contains($id) {
        return array_key_exists($id, $this->content);
    }

}

class UnsupportedOperationException extends Exception {

}

$repository = new UserRepository;
//$repository = new TransactionRepository;

$repository->create("teszt1");
$repository->create("teszt2");
$repository->create("teszt3");

$repository->deleteById(5);
$repository->deleteById(2);

$repository->update(1, "Módosított");

$repository->findById(2);
$repository->findById(0);

var_dump($repository->findAll());

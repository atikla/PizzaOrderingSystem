<?php
class adminlist extends dao {
  
    private $adminlist;
  
  
    //get property
    public function __get($property) {
      if (property_exists($this, $property)) {
        return $this->$property;
      }
    }
  
    //set property
    public function __set($property, $value) {
      if (property_exists($this, $property)) {
        $this->$property = $value;
      }
  
      return $this;
    }
  
    public function showadmins(){
  
      $sql='SELECT AdminID FROM admin ';
      $con = $this->openconnection();
      $stmt = $con->prepare($sql);
      $stmt->execute();
      $data = array();

      while($row  = $stmt->fetch(PDO::FETCH_ASSOC)){
        $data[] = $row;
      }
      if(!empty($data)){
        $iteration              = 0;
        $sizeofarray            = sizeof($data);
        $adminlistarrayofarray  = [];
        $adminlistarrayofobject = [];
        
        while($iteration < $sizeofarray ){
          $newadmin = new admin();
          $newadmin->__set('AdminID', $data[$iteration]['AdminID']);

          $adminlistarrayofarray  [$iteration] = $newadmin->get();
          $adminlistarrayofobject [$iteration] = $newadmin;
          $iteration++;
        }
        $con = null;
        $this->__set('adminlist' , $adminlistarrayofobject);
        return $adminlistarrayofarray;
      } else {
        return false;
  
      }
  
    }
  }
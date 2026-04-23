<?php

class homepagemodel{
    private $modelvar;
    public function __construct($conn){
        $this->modelvar=$conn;
    }

    public function getactivehighlights()
    {
        $sql="  SELECT * 
                FROM highlights 
                WHERE status = 'active' 
                ORDER BY display_order ASC 
                LIMIT 6";
        $stmt = $this->modelvar->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);        
    }




}
?>
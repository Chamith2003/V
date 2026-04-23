<?php

class systemsettingsmodel{
    private $modelvar;
    public function __construct($conn){
        $this->modelvar=$conn;
    }

    public function getallhighlights() {
        $sql = "SELECT * FROM highlights ORDER BY status ASC, display_order ASC, created_at DESC";
        $stmt=$this->modelvar->prepare($sql);
        $stmt->execute();
        $result=$stmt->get_result();//gets the result of the query
        return $result->fetch_all(MYSQLI_ASSOC);//converts to an assoc array and then returns it
    }

    public function gethighlightdetails($highlightId){
        $sql="SELECT * FROM highlights WHERE id=?";
        $stmt = $this->modelvar->prepare($sql);
        $stmt->bind_param("i",$highlightId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();//here keys are the column names
    }

    public function updatehighlight($highlightId,$title,$description,$displayOrder,$status,$mediaUrl){

        $sql=  "UPDATE highlights
                SET title=?, description=?, media_url=?, display_order=?, status=?
                WHERE id=?";
        $stmt=$this->modelvar->prepare($sql);        
        $stmt->bind_param("sssisi",$title,$description,$mediaUrl,$displayOrder,$status,$highlightId);
        $stmt->execute();//php returns null by default
        
    }


    public function createhighlight($title,$description,$displayOrder,$status,$mediaUrl){

        $sql="INSERT INTO highlights(title, description, media_url, display_order, status)
        VALUES (?,?,?,?,?)";
        $stmt=$this->modelvar->prepare($sql);
        $stmt->bind_param("sssis",$title,$description,$mediaUrl,$displayOrder,$status);
        $stmt->execute();
    }
       

    public function deactivatehighlight($highlightId){
        $sql=  "UPDATE highlights
                SET status = 'inactive'
                WHERE id=?";
        $stmt=$this->modelvar->prepare($sql);
        $stmt->bind_param("i",$highlightId);
        $stmt->execute();//php returns null by default

    }

     public function activatehighlight($highlightId){
        $sql=  "UPDATE highlights
                SET status = 'active'
                WHERE id=?";
        $stmt=$this->modelvar->prepare($sql);
        $stmt->bind_param("i",$highlightId);
        $stmt->execute();//php returns null by default

    }

    




}


?>
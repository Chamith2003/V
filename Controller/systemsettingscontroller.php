<?php

class systemsettingscontroller{

private $ctrlvar;
public function __construct($systemsettingsmodel){
    $this->ctrlvar=$systemsettingsmodel;
}
    
 public function getallhighlights() {
        header('Content-Type: application/json');
        
        try {
            $highlights = $this->ctrlvar->getallhighlights();
            
            echo json_encode([
                'success' => true,
                'highlights' => $highlights
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Failed to fetch highlights: ' . $e->getMessage()
            ]);
        }
    }



public function gethighlightdetails(){
    header('Content-Type: application/json');
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            exit();
        }
    $highlightId = $_POST['highlightId'] ?? null;    
    
    try{
        $highlight=$this->ctrlvar->gethighlightdetails($highlightId);
        echo json_encode([ 
            'success' => true,
            'highlight'=> $highlight
        ]);
    }
    catch(Exception $e) {
        echo json_encode([
        'success'=>false,
        'message'=>'Failed to fetch highlight: ' . $e->getMessage()
        ]);

    }
} 

public function updatehighlight(){
    header('Content-Type: application/json');
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            exit();
        }

        $highlightId = $_POST['highlightId'] ?? null; 
        $title=$_POST['title']; 
        $description=$_POST['description'];
        $displayOrder=$_POST['display_order'];
        $status=$_POST['status'];
        $image=$_FILES['image'];  

//file handling

        $allowed = ['image/jpeg','image/png'];
        if (!in_array($image['type'], $allowed)) {
        throw new Exception('Invalid image type');
        }//here image's type is implicityly given by php

        $ext = pathinfo($image['name'], PATHINFO_EXTENSION);//extract extension
        $filename = uniqid('highlight_', true) . '.' . $ext;//create unique file name
        $uploadDir = __DIR__ . '/../uploads/highlights/';
        $path = $uploadDir . $filename;
        move_uploaded_file($image['tmp_name'], $path);//tmp_name is provided by php


        $mediaUrl = '/V/uploads/highlights/' . $filename;

//end of file handling

        try{
            $this->ctrlvar->updatehighlight($highlightId,$title,$description,$displayOrder,$status,$mediaUrl);//make sure to return back here
            echo json_encode([ 
            'success' => true,
            'message'=>'Highlight updated successfully.' 
        ]);

        }
        catch(Exception $e){
        echo json_encode([
        'success'=>false,
        'message'=>'Failed to update highlight: ' . $e->getMessage()
        ]);
        }
        
}

public function createhighlight(){
    header('Content-Type: application/json');
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            exit();
        }


        $title=$_POST['title']; 
        $description=$_POST['description'];
        $displayOrder=$_POST['display_order'];
        $status=$_POST['status'];
        $image=$_FILES['image'];  

        
//file handling

        $allowed = ['image/jpeg','image/png'];
        if (!in_array($image['type'], $allowed)) {
        throw new Exception('Invalid image type');
        }//here image's type is implicityly given by php

        $ext = pathinfo($image['name'], PATHINFO_EXTENSION);//extract extension
        $filename = uniqid('highlight_', true) . '.' . $ext;//create unique file name
        $uploadDir = __DIR__ . '/../uploads/highlights/';
        $path = $uploadDir . $filename;
        move_uploaded_file($image['tmp_name'], $path);//tmp_name is provided by php


        $mediaUrl = '/V/uploads/highlights/' . $filename;

//end of file handling

    try{
        $this->ctrlvar->createhighlight($title,$description,$displayOrder,$status,$mediaUrl);//make sure to return back here
            echo json_encode([ 
            'success' => true,
            'message'=>'Highlight inserted successfully.' 
        ]);

    }catch(Exception $e){
         echo json_encode([
        'success'=>false,
        'message'=>'Failed to insert highlight: ' . $e->getMessage()
        ]);

    }
}


public function deactivatehighlight() {
        header('Content-Type: application/json');
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            exit();
        }

        $highlightId = $_POST['highlightId'] ?? null;
        
        try {
            $this->ctrlvar->deactivatehighlight($highlightId);//make sure to return back here
            
            echo json_encode([
                'success' => true,
                'message' => 'Highlight deactivation successful'
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Failed to deactivate highlight: ' . $e->getMessage()
            ]);
        }
    }






public function activatehighlight() {
        header('Content-Type: application/json');
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            exit();
        }

        $highlightId = $_POST['highlightId'] ?? null;
        
        try {
            $this->ctrlvar->activatehighlight($highlightId);//make sure to return back here
            
            echo json_encode([
                'success' => true,
                'message' => 'Highlight activation successful'
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Failed to activate highlight: ' . $e->getMessage()
            ]);
        }
    }











}


?>
<?php
class volunteermodel{
    private $modelvar;
    public function __construct($conn){
        $this->modelvar=$conn;
    }
    public function getvolunteerlocations($userId) {
    $stmt = $this->modelvar->prepare("SELECT preferred_location_1, preferred_location_2, levelpoints, starpoints FROM volunteer WHERE userid = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    
    if (!$data) {
        return [
            'preferred_location_1' => 'Not Set',
            'preferred_location_2' => 'Not Set',
            'levelpoints' => 0,
            'starpoints' => 0

        ];
    }
    
    return [
        'preferred_location_1' => $data['preferred_location_1'] ?? 'Not Set',
        'preferred_location_2' => $data['preferred_location_2'] ?? 'Not Set',
        'levelpoints' => $data['levelpoints'] ?? 0,
        'starpoints' => $data['starpoints'] ?? 0
    ];
}
    public function getlevelpoints($userId){
        $stmt=($this->modelvar)->prepare("SELECT levelpoints FROM volunteer WHERE userid = ?");
        $stmt->bind_param("i",$userId);
        $stmt->execute();
        $result=($stmt->get_result())->fetch_assoc();
        return $result['levelpoints'];
    }



} 



?>

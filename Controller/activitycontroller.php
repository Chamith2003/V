<?php
class activitycontroller
{

    private $ctrlvar;
    private $openedEvents = [];
    public function __construct($model)
    {
        $this->ctrlvar = $model;
        //store the passed model in $ctrlvar for use in the rest of the file
    }

    public function displayevents($filtertype='all',$userId=null)
    {
        // Call the model's fetchevents method to get all events
        try {
            $this->ctrlvar->fetchevents();//always call this to update dates
            $this->openedEvents = $this->ctrlvar->getopenedevents();//get the list of events with peer rating window open


            if($filtertype ==='enrolled' && $userId){
                $events=$this->ctrlvar->fetchenrolledevents($userId);
            } elseif($filtertype === 'standard' && $userId){
                $organized = $this->ctrlvar->fetchorganizedevents($userId);//thus standard filter means standard organized events and later remove annual ones from that(see line below)
                $events = array_filter($organized, fn($e) => !$e['is_annual']);
            } elseif($filtertype === 'annual'){
                $events = $this->ctrlvar->fetchannualevents();
            } else{
                $events = $this->ctrlvar->fetchevents();//updates dates of all events yet returns only authorized and undeleted events used only in absecnce of above filters
            }            
            // $organizedevents=$this->ctrlvar->fetchorganizedevents($_SESSION['user_id']);
            // $annualevents=$this->ctrlvar->fetchannualevents();
            // $enrolledevents=$this->ctrlvar->fetchenrolledevents();

            if ($userId) {
            foreach ($events as &$event) {
                $event['is_enrolled'] = $this->ctrlvar->isuserenrolled($userId, $event['event_id']);//add a new key to event array
            }
            unset($event);//remove the refernece to last event-safety
        }


            return ['success' => true, 'data' => $events,'opened_events'=>$this->openedEvents];
        } catch (Exception $e) {
            error_log("Error getting events: " . $e->getMessage());
            return ['success' => false, 'message' => 'Failed to load events', 'data' => [],'opened_events'=>[]];
        }

    }




}
?>
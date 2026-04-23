<?php
//business logic of the achievement section

class achievementcontroller{

    private $ctrlvar;
    public function __construct($model){
        $this->ctrlvar=$model;
    }

    //configuring the constants eg:level thresholds

    private $levelthresholds=[
        // (level=>minimum points required)
        1=>0,
        2=>15,
        3=>50,
        4=>120,
        5 => 250,
        6 => 450,
        7 => 750,
        8 => 1150,
        9 => 1700,
        10 => 2400,
        11 => 3300,
        12 => 4500,
        13 => 6000,
        14 => 8000,
        15 => 10500

    ];

    private $badgerequirements=[
        //Badge Requirements: badge-name => [event type, events required, top N rank]
        'Wave Saver' => ['Beach Cleanup', 40, 3],
        'Mountain Sentinel'=>['Mountain Cleanup', 12, 2],
        'Coral Guardian' => ['Coral Restoration', 25, 2],
        'Forest Builder' => ['Tree Planting', 35, 3],
        'Mangrove Starter' => ['Mangrove Restoration', 20, 2],
        'Urban Protector'=>['City Cleanup',50,4]
    ];


    public function renderachievements(){
        //render achievements section for settings page + return all data needed for the UI display
    
        $volunteerId=$_SESSION['user_id']??null;
        if(!$volunteerId){
            return[
                'success'=>false,
                'message'=>'user not logged in'
            ];
        }
        try{
            $stats=$this->getvolunteerstats($volunteerId); //return format is of keys star_points,level_points,level,points_to_next_level,projects_completed,hours_volunteered
            $badges=$this->getearnedbadges($volunteerId);//return format is of keys name,count,earned_date
            $leaderboard=$this->getleaderboarddata($volunteerId);
            //returns assoc array of format 'current_rank'=>$currentrank,'users'=>$formattedleaderboard
            //here formattedleaderboard has keys of format rank,name,points,is_current_user 
            //here $stats is returning an associtive array with keys of format 
            return [
                'success'=>true,
                'data'=>[//the data part is also going to be another associative array (unpacking and re-packing)
                    //repacking based on the keys returned from the getvolunteerstats function
                    'star_points'=>$stats['star_points'],
                    'level'=>$stats['level'],
                    'level_points'=>$stats['level_points'],
                    'points_to_next_level'=>$stats['points_to_next_level'],
                    'projects_completed'=>$stats['projects_completed'],
                    'hours_volunteered'=>$stats['hours_volunteered'],
                    'badges'=>$badges,
                    'leaderboard'=>$leaderboard

                ]
            ];

        }
        catch(Exception $e){
            return[
                'success'=>false,
                'message'=>$e->getMessage()
            ];

        }

    }

    public function getvolunteerstats($volunteerId){
        //get complete volunteer statisitcs for display
        //access model functions to return levelpoints,starpoints,noofmembers
        $basicstats=$this->ctrlvar->getvolunteerbasicstats($volunteerId);
        if(!$basicstats){
            throw new Exception('volunteer not found');
        }
        //get additional calculated stats from the returned data from $basicstats
        $levelpoints=$basicstats['levelpoints'];
        $starpoints=$basicstats['starpoints'];

        $currentlevel=$this->calculatelevel($levelpoints);//returns currentlevel(singular)
        $pointstonextlevel=$this->getpointstonextlevel($currentlevel,$levelpoints);
        $projectscompleted=$this->ctrlvar->getprojectscompleted($volunteerId);//gives a count
        $hoursvolunteered=$this->ctrlvar->gettotalhoursvolunteered($volunteerId); //gives totalhours
        return[
            'star_points'=>$starpoints,
            'level_points'=>$levelpoints,
            'level'=>$currentlevel,
            'points_to_next_level'=>$pointstonextlevel,
            'projects_completed'=>$projectscompleted,
            'hours_volunteered'=>$hoursvolunteered ?? 0
        ];

    }

    public function getearnedbadges($volunteerId){
        //get earned badges
        $badges=$this->ctrlvar->getvolunteerbadgeswithcounts($volunteerId);//returns an entire table with 'badgeearned','badge_count',MIN(earneddate) as 'first_earned' columns for a specific volunteerId
        $formattedbadges=[];
        foreach($badges as $badge){
            $badgename=$badge['badgeearned'];//using two steps for clarity
            $formattedbadges[]=[
                'name'=>$badgename,
                'count'=>$badge['badge_count'],
                'earned_date'=>$badge['first_earned']
            ];
        }
        return $formattedbadges;//has keys name,count,earned_date

    }

    public function getleaderboarddata($volunteerId){
        //get leaderboard data with current user's postion
        //get current users rank
        $currentrank=$this->ctrlvar->getvolunteerrank($volunteerId);//put in the big board
        $fetcheduserdetails=$this->ctrlvar->getvolunteerdetails($volunteerId);//has the logged in user's 
        
        return[
            'current_rank'=>$currentrank,
            'user'=>$fetcheduserdetails
        ];
    }

    public function calculatelevel($levelpoints){
        //calculate volunteer's current level from level points
    
        $currentlevel=1;
        //calculate level using the threshold array intialized at the top 
        foreach($this->levelthresholds as $level=>$threshold){//breaks the array into key–value pairs so that Loop(1)	$level(1)	$threshold(100), Loop(2)	$level(2)	$threshold(300)
        if($levelpoints>=$threshold){
            $currentlevel=$level;//upgrade the currentlevel gradually if the levelpoints of the user is greater than the thresold value, if so update the currentlevel to the 'level' in the constant array
        }
        else{//if levelpoints are less than threshold break
            break;
        }
        }
        return $currentlevel;

    }
    public function getpointstonextlevel($currentlevel,$currentpoints){
        //get points needed to reach the next level from the CURRENT POINTS
        $nextlevel=$currentlevel+1;
        if(!isset($this->levelthresholds[$nextlevel])){//is not set
            //if the next level DOES NOT exist in the levelthresholds array at the top (at MAX level)
            return 0;
        }
        $nextthreshold=$this->levelthresholds[$nextlevel];
        return max(0,$nextthreshold-$currentpoints);

    }

    public function shouldlevelup($volunteerId){
        //check if volunteer should level up

        $stats=$this->ctrlvar->getvolunteerbasicstats($volunteerId);//return levelpoints,starpoints,noofmembers
        $currentlevel=$this->calculatelevel($stats['levelpoints']);//get using assoc array of $stats
        $nextlevel=$currentlevel+1;

        if(!isset($this->levelthresholds[$nextlevel])){//reached maximum level
            return[
                'should_level_up'=>false,
                'new_level'=>null

            ];
        }
        $nextlevelthreshold=$this->levelthresholds[$nextlevel];
        if($stats['levelpoints']>=$nextlevelthreshold){//increment level if current level points have passed the next levle threshold
            return [
                'should_level_up'=>true,
                'new_level'=>$nextlevel
            ];

        }
        return [

            'should_level_up'=>false,
            'new_level'=>null
        ];



    }
    // public function shouldleveldown($volunteerId){
    //     //check if volunteer should level down (after penalty)

    //     $stats=$this->ctrlvar->getvolunteerbasicstats($volunteerId);//return levelpoints,starpoints,noofmembers
    //     $currentlevel=$this->calculatelevel($stats['levelpoints']);//get the level of volunteer with current levelpoints
    //     $currentlevelthreshold=$this->levelthresholds[$currentlevel];//get lower bound (min amt of pts required) of current level
    //     if($stats['levelpoints']<$currentlevelthreshold){//current levelpoints are less than required minimum therefore level down
    //         $newlevel=$this->calculatelevel($stats['levelpoints']);
    //         return[
    //             'should_level_down'=>true,
    //             'new_level'=>$newlevel
    //         ];
    //     }
    //     return ['should_level_down'=>false,'new_level'=>null];

    // }
    public function checkandawardbadges($volunteerId){
        //check and award badges for volunteer
        $newbadges=[];//list of awarded (new) badges
        foreach($this->badgerequirements as $badgename=>$requirements){
            //check if already has badge
            //unpack the $requirements into each constituent
            list($eventtype,$eventsperbadge,$topNrank)=$requirements;//here $eventsperbadge means the number of events needed to obtain the badge
            //get event count and current badge count
            $eventcount=$this->ctrlvar->geteventcountbycategory($volunteerId,$eventtype);//returns a count
            //total number of events completed in a given category for a GIVEN volunteer
            $currentbadgecount=$this->ctrlvar->badgecount($volunteerId,$badgename);//returns bagde count
            
            //find number of badges volunteer should have
            $shouldhave=floor($eventcount/$eventsperbadge);//total/number of events deemed completed to get a badge

            //check if top performer
            if($shouldhave>0){
                $topperformers=$this->ctrlvar->gettopperformersincategory($eventtype,$topNrank);//returns a 1D array of volunteer Ids of indicating top volunteers of particuliar EVENT TYPE
                if(!in_array((int)$volunteerId, array_map('intval', $topperformers))){//check if $volunteerId is not inside $topperformers array and array_map('intval', ...) converts every element to an integer
                    continue;//skip if volunteer is not a top performer
                }
            }
            //do the following if they are a topvolunteer
            $toaward=min(1, $shouldhave-$currentbadgecount);
            for($i=0;$i<$toaward;$i++){
                $success=$this->ctrlvar->awardbadge($volunteerId,$badgename);//insert badge awarded into DB
                if($success){
                    $newbadges[]=[
                        'name'=>$badgename
                    ];//every time a badge is successfully awarded, you append a new associative array {eg: ['name' => 'Badge 1'] }to $newbadges
                      //if a volunteer earns multiple badges in the loop they are added like ['name' => 'Badge 1'],['name' => 'Badge 2'] etc all with key 'name'
                }
            }
        }
        return $newbadges;
    }
    
    public function processeventcompletion($eventId){
        //process event completion and award points to all volunteers
        //this is the MAIN ENTRY POINT FOR THE ACHIEVEMENT SYSTEM

        try{
            //guard against double processing
            $event = $this->ctrlvar->geteventbasicdetails($eventId);
            if(!$event){
                return[
                    'success'=>false,
                    'message'=>'Event not found or has been deleted'
                ];
            }
            if ($event && $event['points_processed']) {
                return [
                    'success' => false,
                    'message' => 'Points have already been awarded for this event'
                ];
            }

            //validate event
            if($this->ctrlvar->iseventcancelled($eventId)){//returns if event IS cancelled
                return [
                    'success'=>false,
                    'message'=>'Cannot award points for cancelled events'

                ];
            }

            if(!$this->ctrlvar->iseventcompleted($eventId)){//returns only if completed
                //if this event is NOT completed

                return[
                    'success'=>false,
                    'message'=>'Event must be marked as completed first'
                ];
            }
            $volunteers=$this->ctrlvar->getvolunteerswhoparticipated($eventId);
            //get all volunteers who participated (have just participated)
            //gives a simple 1D array of volunteer_ids

            if(empty($volunteers)){
                return[
                    'success'=>false,
                    'message'=>'No volunteers with attendance marked'
                ];
            }

            $results=[];
            $levelups=[];
            $newbadges=[];

            //process each volunteer
            foreach($volunteers as $volunteerId){
                //check if already awarded
                if($this->ctrlvar->havepointsbeenawarded($volunteerId,$eventId)){
                    continue;//skip if already awarded + take event to be fully done(including ratings) iff its called 'completed' in participation_status and vise versa
                }
                //following is called for each volunteer and the method returns keys volunteer_id,star_points,level_points,ratings(has peer,task,attendance )
                $attendancecheck=$this->canreceivepoints($volunteerId,$eventId);
                if($attendancecheck['can_receive']==true){//award only if attendance and other checks are done
                $pointsawarded=$this->calculateandawardpoints($volunteerId,$eventId);
                $results[$volunteerId]=$pointsawarded;//here results will be an assoc array with keys being volunteerIds (multiple Ids) (just a normal array with indexes being volunteerIds)
                }
                //check for levelup
                $levelupcheck=$this->shouldlevelup($volunteerId);//retruns assoc array with keys 'should_level_up','new_level'
                if($levelupcheck['should_level_up']){//true or false
                    $levelups[$volunteerId]=$levelupcheck['new_level'];//make a 1D simple array with keys(indexes) being the volunteerIds and their value being the newlevel
                }
                //check for new badges
                $badges=$this->checkandawardbadges($volunteerId);//returns a series of assoc arrays each with key 'name' eg: ['name' => 'Badge 1'],['name' => 'Badge 2'] etc
                if(!empty($badges)){
                    $newbadges[$volunteerId]=$badges;//NEW badges (list of newly awarded badges) AWARDED to considered volunteerId
                }
            }

$this->ctrlvar->markpointsprocessed($eventId);

            return[
                'success'=>true,
                'volunteers_processed'=>count($results),
                'results'=>$results,
                'level_ups'=>$levelups,
                'new_badges'=>$newbadges
                
            ];
        }
        catch(Exception $e){
            return[
                'success'=>false,
                'message'=>'Error processing event completion:'.$e->getMessage()
            ];

        }

    }

    public function calculateandawardpoints($volunteerId,$eventId){
        //calculate and award points for a volunteer in an event
    
    
        //get all three rating components + these return values respectively avg_rating,avg_rating,score
        $peerrating=$this->ctrlvar->getaveragepeerrating($volunteerId,$eventId)??0;
        $taskrating=$this->ctrlvar->getaveragetaskrating($volunteerId,$eventId)??0;
        $attendancescore=$this->ctrlvar->getattendancescore($volunteerId,$eventId)??0;

        //get event's allocated points
        $eventrewards=$this->ctrlvar->geteventrewards($eventId);//returns an assoc array with keys 'starpoints_reward'=>xxx,'levelpoints_reward'=>xxx
        $allocatedstarpoints=$eventrewards['starpoints_reward']??0;
        $allocatedlevelpoints=$eventrewards['levelpoints_reward']??0;

        //calculate earned points using formula (first pack it into an assoc array)
        $ratings=[
            'peer'=>$peerrating,
            'task'=>$taskrating,
            'attendance'=>$attendancescore
        ];

        $earnedstarpoints=$this->calculateearnedpoints($ratings,$allocatedstarpoints);
        $earnedlevelpoints=$this->calculateearnedpoints($ratings,$allocatedlevelpoints);

        //award the points and inset into the database
        $this->ctrlvar->awardstarpoints($volunteerId,$earnedstarpoints);
        $this->ctrlvar->awardlevelpoints($volunteerId,$earnedlevelpoints);

        //update participation status and FORMALLY CLOSE EVENT FOR VOLUNTEER
        $this->ctrlvar->updateparticipationstatus($volunteerId,$eventId,'completed');

        return [
            'volunteer_id'=>$volunteerId,
            'star_points'=>$earnedstarpoints,
            'level_points'=>$earnedlevelpoints,
            'ratings'=>$ratings//each constituent peer,task,attendance rating

        ];

    
    }
    public function calculateearnedpoints($ratings,$allocatedpoints){
        //calculate earned points based on ratings     
        if($ratings['peer']!=0){   
        $totalratings=(($ratings['attendance']/5)*0.3)+(0.7*(($ratings['peer']/5)*($ratings['task']/5)));//unpack form $ratings
        $earnedpoints=round(($totalratings)* $allocatedpoints);
        return max(0,$earnedpoints);//ensure non negativeness
        }
        else{
            $totalratings=(($ratings['attendance']/5)*0.3)+(0.7*(1*($ratings['task']/5)));//unpack form $ratings
            $earnedpoints=round(($totalratings)* $allocatedpoints);
            return max(0,$earnedpoints);//ensure non negativeness
        }
    }

    public function strikeattendancepenalty($volunteerId,$eventId){
        $reward=$this->ctrlvar->geteventrewards($eventId);
        $penalty=$reward['levelpoints_reward']*0.3;
        $convertedpenalty=(int) round($penalty);
        return $this->ctrlvar->deductattendancepenalty($convertedpenalty, $volunteerId);

    }
    public function canreceivepoints($volunteerId,$eventId){
        //validate if volunteer can receive points for event

        //check if he/she has attended
        if(!$this->ctrlvar->didattend($volunteerId,$eventId)){//return a boolean(yes=1/no=0)
            $this->strikeattendancepenalty($volunteerId,$eventId);    
            return [
                'can_receive'=>false,
                'reason'=>'Attendance not marked'
            ];
        }
        //check if event is completed
        if(!$this->ctrlvar->iseventcompleted($eventId)){
            return[
                'can_receive'=>false,
                'reason'=>'Event not completed'
            ];
        }

        //check if already awarded
        if($this->ctrlvar->havepointsbeenawarded($volunteerId,$eventId)){
            return[
                'can_receive'=>false,
                'reason'=>'Points already awarded'
            ];
        }

        return[
            'can_receive'=>true,
            'reason'=>''
        ];

    }

    //AJAX ENDPOINTS
    public function getachievementdata(){
        //get achievement data for AJAX request
        //returns a JSON response to reload the achievement stuff
        header('Content-Type: application/json');
        $volunteerId=$_SESSION['user_id']??null;
        if(!$volunteerId){
            echo json_encode([
                'success'=>false,
                'message'=>'Not logged in'
            ]);
            return;
        }
        $result=$this->renderachievements();//format is like data=> star_points,level,level_points,points_to_next_level,projects_completed,hours_volunteered,badges,leaderboard
        echo json_encode($result);//result has .success and .data inside it
    }


}
?>
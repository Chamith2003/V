-- Schema Alterations for V Database
-- Run this file AFTER v.sql has been executed
-- These alterations are subject to change based on future requirements

use v;


-- volunteer table ehnancements 
ALTER TABLE volunteer 
ADD COLUMN volunteer_experience TEXT,
ADD COLUMN preferred_location_1 VARCHAR(100),
ADD COLUMN preferred_location_2 VARCHAR(100),
ADD COLUMN preferred_location_3 VARCHAR(100);


-- volunteering_program table enhancements
ALTER TABLE volunteering_program 
ADD COLUMN duration VARCHAR(50);

ALTER TABLE volunteering_program 
ADD COLUMN time TIME DEFAULT '07:00:00' AFTER event_date;

ALTER TABLE volunteering_program 
ADD COLUMN isauthorized TINYINT(1) DEFAULT NULL AFTER event_type;




#ALTER TABLE item MODIFY COLUMN emoji VARCHAR(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
#ALTER TABLE item CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;


-- item table enhancements
ALTER TABLE item
DROP COLUMN quantity,
ADD COLUMN description TEXT,
ADD COLUMN price DECIMAL(12,2) DEFAULT 0,
ADD COLUMN stock_XS INT DEFAULT 0,
ADD COLUMN stock_S INT DEFAULT 0,
ADD COLUMN stock_M INT DEFAULT 0,
ADD COLUMN stock_L INT DEFAULT 0,
ADD COLUMN stock_XL INT DEFAULT 0,
ADD COLUMN stock_XXL INT DEFAULT 0;

ALTER TABLE item
ADD COLUMN is_active TINYINT(1) DEFAULT 1 AFTER stock_XXL;


-- request table enhancements
ALTER TABLE request
ADD COLUMN type  VARCHAR(50) DEFAULT '0' 
CHECK (type IN ('applytoberep', 'requesttosponsor', 'requestforsponsorship')),
ADD COLUMN linkedin  VARCHAR(100); 


-- create a peer_rating_assignment table to do thw working(matching peers)
CREATE TABLE IF NOT EXISTS peer_rating_assignment (
    assignment_id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT NOT NULL,
    rater_id INT NOT NULL,
    ratee_id INT NOT NULL,
    shared_task_count INT DEFAULT 1,  -- For priority sorting
    needs_bias_adjustment BOOLEAN DEFAULT FALSE,  -- Flag for <5 coverage
    status VARCHAR(20) DEFAULT 'pending' 
        CHECK (status IN ('pending', 'completed')),
    created_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    
    UNIQUE KEY (event_id, rater_id, ratee_id),
    FOREIGN KEY (event_id) REFERENCES volunteering_program(event_id) ON DELETE CASCADE,
    FOREIGN KEY (rater_id) REFERENCES volunteer(userid) ON DELETE CASCADE,
    FOREIGN KEY (ratee_id) REFERENCES volunteer(userid) ON DELETE CASCADE,
    CHECK (rater_id != ratee_id)
);


-- alterations to the task_performance rating
ALTER TABLE task_performance_rating 
ADD COLUMN comment TEXT AFTER performance_score;




-- alter donation table 

ALTER TABLE donation 
ADD COLUMN order_id VARCHAR(100) UNIQUE,
ADD COLUMN payment_id VARCHAR(100),
ADD COLUMN payment_method VARCHAR(50),
ADD COLUMN transaction_date DATETIME;


-- user table enhancements
ALTER TABLE user ADD COLUMN status VARCHAR(20) DEFAULT 'active' 
CHECK (status IN ('active', 'suspended'));





ALTER TABLE attendance_rating
ADD UNIQUE KEY unique_event_volunteer (event_id, volunteer_id);



ALTER TABLE volunteering_program 
ADD COLUMN gmap_link VARCHAR(500) AFTER location;



ALTER TABLE volunteering_program 
ADD COLUMN allocated_budget INT AFTER scale;

ALTER TABLE volunteering_program
ADD COLUMN is_deleted BOOLEAN DEFAULT FALSE;


ALTER TABLE peer_rating_assignment
    DROP COLUMN shared_task_count, -- only 1 task per volunteer
    DROP COLUMN needs_bias_adjustment; -- no bias occurs




CREATE TABLE IF NOT EXISTS org_representative (
    userid INT PRIMARY KEY,
    duration INT CHECK (duration > 0),  -- duration in months
    appointeddate DATE,
    FOREIGN KEY (userid) REFERENCES user(userid) ON DELETE CASCADE
);

ALTER TABLE representative
ADD COLUMN isorgrep TINYINT(1) NOT NULL DEFAULT 0;

ALTER TABLE org_representative
ADD COLUMN is_active TINYINT(1) NOT NULL DEFAULT 1;

ALTER TABLE representative
ADD COLUMN is_active TINYINT(1) NOT NULL DEFAULT 1;



ALTER TABLE sponsor
ADD COLUMN business_registration_number VARCHAR(50) NOT NULL,
ADD COLUMN year_established YEAR NOT NULL,
ADD COLUMN official_website_link VARCHAR(255),
ADD COLUMN about_company TEXT,
ADD COLUMN organization_type VARCHAR(50) NOT NULL,
ADD COLUMN contact_person_name VARCHAR(100) NOT NULL,
ADD COLUMN contact_person_role VARCHAR(100) NOT NULL,
ADD COLUMN contact_person_email VARCHAR(150) NOT NULL,
ADD COLUMN contact_person_contact_number VARCHAR(20) NOT NULL,

ADD COLUMN logo_path VARCHAR(255) NULL DEFAULT '/V/View/userdash/settings/img/profile1.png';






ALTER TABLE donation
ADD COLUMN event_id INT,
ADD FOREIGN KEY (event_id) REFERENCES volunteering_program(event_id) 
ON DELETE CASCADE;


-- calendar related schema


-- -- event change log for tracking rescheduling
-- CREATE TABLE IF NOT EXISTS event_change_log (
--     change_id INT AUTO_INCREMENT PRIMARY KEY,
--     event_id INT NOT NULL,
--     changed_by INT NOT NULL,
--     change_type VARCHAR(50) NOT NULL CHECK (change_type IN 
--         ('date_changed', 'time_changed', 'location_changed', 'cancelled')),
--     old_value TEXT,
--     new_value TEXT,
--     change_date DATETIME DEFAULT CURRENT_TIMESTAMP,
--     FOREIGN KEY (event_id) REFERENCES volunteering_program(event_id) ON DELETE CASCADE,
--     FOREIGN KEY (changed_by) REFERENCES user(userid)
-- );

-- -- reschedule confirmation tracking
-- CREATE TABLE IF NOT EXISTS event_reschedule_confirmation (
--     confirmation_id INT AUTO_INCREMENT PRIMARY KEY,
--     event_id INT NOT NULL,
--     volunteer_id INT NOT NULL,
--     change_id INT NOT NULL,
--     response VARCHAR(20) CHECK (response IN ('confirmed', 'declined', 'pending')),
--     response_date DATETIME,
--     UNIQUE KEY (event_id, volunteer_id, change_id),
--     FOREIGN KEY (event_id) REFERENCES volunteering_program(event_id) ON DELETE CASCADE,
--     FOREIGN KEY (volunteer_id) REFERENCES volunteer(userid) ON DELETE CASCADE,
--     FOREIGN KEY (change_id) REFERENCES event_change_log(change_id) ON DELETE CASCADE
-- );

-- track volunteer leave behavior
CREATE TABLE IF NOT EXISTS volunteer_leave_history (
    leave_id INT AUTO_INCREMENT PRIMARY KEY,
    volunteer_id INT NOT NULL,
    event_id INT NOT NULL,
    leave_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    days_before_event INT NOT NULL,
    level_points_lost INT DEFAULT 0,
    star_points_lost INT DEFAULT 0,
    reason TEXT,
    FOREIGN KEY (volunteer_id) REFERENCES volunteer(userid) ON DELETE CASCADE,
    FOREIGN KEY (event_id) REFERENCES volunteering_program(event_id) ON DELETE CASCADE
);

-- sponsorship tracking for sponsors' calendar
CREATE TABLE IF NOT EXISTS sponsor_event_commitment (
    commitment_id INT AUTO_INCREMENT PRIMARY KEY,
    sponsor_id INT NOT NULL,
    event_id INT NOT NULL,
    commitment_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    commitment_amount DECIMAL(12,2),
    status VARCHAR(20) DEFAULT 'not accepted' CHECK (status IN ('not accepted', 'accepted', 'completed', 'cancelled')),   
    UNIQUE KEY (sponsor_id, event_id),
    FOREIGN KEY (sponsor_id) REFERENCES sponsor(userid) ON DELETE CASCADE,
    FOREIGN KEY (event_id) REFERENCES volunteering_program(event_id) ON DELETE CASCADE
);




CREATE TABLE IF NOT EXISTS route_permissions(

    permission_id INT PRIMARY KEY AUTO_INCREMENT,
    module VARCHAR(50) NOT NULL,
    action VARCHAR(50) NOT NULL,
    allowed_roles TEXT NOT NULL,
    description VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY (module, action)
);





INSERT INTO route_permissions (module, action, allowed_roles) VALUES
('page','homepage','public'),
('page','calendar','public'),
('page','aboutus','public'),
('page','vmap','public'),
('calendar','getevents','volunteer,manager,admin,sponsor,representative,organisationrep'),
('calendar','geteventdetails','volunteer,manager,admin,sponsor,representative,organisationrep'),
('calendar','leaveevent','volunteer,representative,organisationrep'),
('calendar','filterevents','volunteer,manager,admin,sponsor,representative,organisationrep'),
('attendance','mark','manager,representative,organisationrep'),
('user','login','public'),
('user','logout','volunteer,manager,admin,sponsor,representative,organisationrep'),
('user','profile','volunteer,manager,admin,sponsor,representative,organisationrep'),
('user','profileEdit','volunteer,manager,admin,sponsor,representative,organisationrep'),
('user','profileUpdate','volunteer,manager,admin,sponsor,representative,organisationrep'),
('user','forgotpw','public'),
('user','resetpw','volunteer,manager,admin,sponsor,representative,organisationrep'),
('user','updatepassword','volunteer,manager,admin,sponsor,representative,organisationrep'),
('user','deleteaccount','volunteer,manager,admin,sponsor,representative,organisationrep'),
('contact','send','volunteer,sponsor,representative,organisationrep'),
('feedback','sendemail','volunteer,manager,sponsor,representative,organisationrep'),
('pwreset','show','volunteer,manager,admin,sponsor,representative,organisationrep'),
('pwreset','sendcode','public'),
('pwreset','verifycode','public'),
('pwreset','updatepassword','volunteer,manager,admin,sponsor,representative,organisationrep'),
('pwreset','showchange','volunteer,manager,admin,sponsor,representative,organisationrep'),
('registration','register','public'),
('registration','registration_role','public'),
('registration','registration_step1','public'),
('registration','registration_step2','public'),
('registration','registration_step3','public'),
('registration','registration_step4','public'),
('registration','registration_complete','public'),
('registration','registration_success','public'),
('projects','projects','public'),
('projects','projectapprovals','manager'),
('projects','approveEvent','manager'),
('projects','rejectEvent','manager,representative,organisationrep'),
('projects','createevent','manager,representative,organisationrep'),
('projects','events','volunteer,manager,admin,sponsor,representative,organisationrep'),
('projects','deleteevent','manager,representative,organisationrep'),
('projects','updateevent','manager,representative,organisationrep'),
('projects','createeventsuccess','manager,representative,organisationrep'),
('projects','joinevent','volunteer,representative,organisationrep'),
('projects','withdrawevent','volunteer,representative,organisationrep'),
('activity','activity','volunteer,manager,representative,organisationrep'),
('activity','openpeer','manager,representative,organisationrep'),
('task','managetasks','manager,representative,organisationrep'),
('task','createtask','manager,representative,organisationrep'),
('task','edittask','manager,representative,organisationrep'),
('task','deletetask','manager,representative,organisationrep'),
('task','assignvolunteer','manager,representative,organisationrep'),
('task','removevolunteer','manager,representative,organisationrep'),
('task','assignmultiplevolunteers','manager,representative,organisationrep'),
('inventory','inventorymanagement','manager'),
('inventory','createitem','manager'),
('inventory','updateitem','manager'),
('inventory','deleteitem','manager'),
('volunteer','berepresentative','volunteer'),
('volunteer','submitApplication','volunteer'),
('volunteer','updateApplication','volunteer'),
('volunteer','deleteApplication','volunteer'),
('volunteer','submittedapplication','volunteer,representative,organisationrep'),
('representative','repapproveeventbudgets','representative,organisationrep'),
('sponsor','requesttosponsor','sponsor'),
('sponsor','sponsorshipactivity','volunteer,manager,admin,sponsor,representative,organisationrep'),
('manager','managerapproveeventbudgets','manager'),
('manager','requestsponsorships','manager'),
('manager','approvesponsorships','manager'),
('manager','incomingsponreq','manager'),
('manager','approvereppost','manager'),
('manager','approveApplication','manager'),
('manager','rejectApplication','manager'),
-- newly added for cycle 3
('manager','selectorgrep','manager'),
('manager','appointorgreps','manager'),
('manager','managereps','manager'),
('projects','annualeventapproval','organisationrep'),
('projects','annualeventstatus','manager'),
('projects','handleAnnualEventApproval','organisationrep'),
-- end of additions for cycle 3
('admin','systemoverview','admin,manager'),
('admin','systemsettings','admin'),
('admin','manageusers','admin'),
('admin','getusersdata','admin'),
('admin','getuserdetails','admin'),
('admin','getstats','admin'),
('admin','updateuser','admin'),
('admin','toggleuserstatus','admin'),
('admin','deleteuser','admin'),
('admin','generatereport','admin,manager'),
('admin','getallhighlights','admin'),
('admin','gethighlightdetails','admin'),
('admin','updatehighlight','admin'),
('admin','createhighlight','admin'),
('admin','deactivatehighlight','admin'),
('admin','activatehighlight','admin'),
('donation','senddonation','volunteer,sponsor,representative,organisationrep'),
('donation','processdonation','volunteer,sponsor,representative,organisationrep'),
('donation','successfuldonation','volunteer,sponsor,representative,organisationrep'),
('donation','payherenotify','volunteer,sponsor,representative,organisationrep'),
('merch','buymerch','volunteer,manager,admin,sponsor,representative,organisationrep'),
('merch','getitems','volunteer,sponsor,representative,organisationrep'),
('merch','getpoints','volunteer,sponsor,representative,organisationrep'),
('merch','purchase','volunteer,sponsor,representative,organisationrep'),
('merch','history','volunteer,sponsor,representative,organisationrep'),
('rating','peer','volunteer,representative,organisationrep'),
('rating','ratetasks','manager,representative,organisationrep'),
('rating','submitpeerrating','volunteer,representative,organisationrep'),
('rating','submittaskrating','manager,representative,organisationrep'),
('achievement','getdata','volunteer,representative,organisationrep'),
('achievement','processevent','volunteer,manager,admin,sponsor,representative,organisationrep'),
('achievement','leaveevent','volunteer,representative,organisationrep'),
('achievement','canreceivepoints','volunteer,representative,organisationrep'),
('achievement','getstats','volunteer,representative,organisationrep'),
('achievement','getleaderboard','volunteer,representative,organisationrep');


-- week 3 additions


-- Table for annual event approvals
CREATE TABLE IF NOT EXISTS annual_event_approvals (
    approval_id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT NOT NULL,
    approver_id INT NOT NULL,
    approval_status ENUM('approved', 'rejected') NOT NULL,
    approval_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (event_id) REFERENCES volunteering_program(event_id),
    FOREIGN KEY (approver_id) REFERENCES user(userid),
    UNIQUE KEY unique_approval (event_id, approver_id)
);


ALTER TABLE donation 
DROP CHECK donation_chk_3,
DROP COLUMN currentamount,
DROP COLUMN donationdate,
DROP COLUMN payment_method,
DROP COLUMN payment_id,
ADD COLUMN transaction_id VARCHAR(100);




INSERT INTO route_permissions (module, action, allowed_roles) VALUES

('user','uploadLogo','public'),
('registration','s_registration_step1','public'),
('registration','s_registration_step2','public'),
('registration','s_registration_step3','public'),
('registration','s_registration_step4','public'),
('registration','s_registration_complete','public');



ALTER TABLE volunteer 
ADD COLUMN profile_path VARCHAR(255) NULL ;




INSERT INTO route_permissions (module, action, allowed_roles) VALUES
('notification', 'getunreadcount', 'volunteer,manager,admin,sponsor,representative,organisationrep'),
('notification', 'getnotifications', 'volunteer,manager,admin,sponsor,representative,organisationrep'),
('notification', 'markasread', 'volunteer,manager,admin,sponsor,representative,organisationrep'),
('notification', 'markallasread', 'volunteer,manager,admin,sponsor,representative,organisationrep'),
('notification', 'closenotification', 'volunteer,manager,admin,sponsor,representative,organisationrep');


CREATE TABLE IF NOT EXISTS notification(

 notification_id INT AUTO_INCREMENT PRIMARY KEY,
    receiver_id INT NOT NULL,
    type VARCHAR(100) NOT NULL,
    category VARCHAR(50) NOT NULL CHECK (category IN 
        ('calendar', 'task', 'event', 'representative', 'sponsorship', 
         'donation', 'leaderboard', 'admin', 'system','merch')),
    title VARCHAR(200) NOT NULL,
    message TEXT NOT NULL,
    link VARCHAR(255),
    db_object_id INT,
    db_object_type VARCHAR(50),
    priority VARCHAR(20) DEFAULT 'normal' CHECK (priority IN ('low', 'normal', 'high', 'urgent')),
    is_sent BOOLEAN DEFAULT FALSE,
    is_read BOOLEAN DEFAULT FALSE,
    is_closed BOOLEAN DEFAULT FALSE,
    created_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    read_date DATETIME NULL,
    scheduled_date DATETIME NULL,
    expiry_date DATETIME NULL,
    FOREIGN KEY (receiver_id) REFERENCES user(userid) ON DELETE CASCADE
);



ALTER TABLE donation 
ADD COLUMN status VARCHAR(20) DEFAULT 'pending';

INSERT INTO route_permissions (module, action, allowed_roles) 
VALUES ('merch', 'processmerchpayment', 'volunteer,sponsor');

INSERT INTO route_permissions (module, action, allowed_roles) 
VALUES ('merch', 'successfulpurchase', 'volunteer,sponsor');

INSERT INTO route_permissions (module, action, allowed_roles) 
VALUES ('merch', 'payherenotify', 'public');

INSERT INTO route_permissions (module, action, allowed_roles) 
VALUES ('merch', 'initiatepayment', 'volunteer,sponsor');

ALTER TABLE item_purchase_log
ADD COLUMN payment_id VARCHAR(100) NULL AFTER log_id,
ADD COLUMN order_id VARCHAR(100) NULL AFTER payment_id,
ADD COLUMN size VARCHAR(10) NULL AFTER quantity_taken,
ADD COLUMN points_used INT DEFAULT 0 AFTER size,
ADD COLUMN discount DECIMAL(12,2) DEFAULT 0.00 AFTER points_used,
ADD COLUMN paid_amount DECIMAL(12,2) NULL AFTER discount,
ADD COLUMN sponsorid INT NULL AFTER volunteer_id,
ADD FOREIGN KEY (sponsorid) REFERENCES user(userid);

ALTER TABLE item_purchase_log 
MODIFY volunteer_id INT NULL;




-- Budget Items Table
CREATE TABLE IF NOT EXISTS event_budget_item (
    budget_item_id INT PRIMARY KEY AUTO_INCREMENT,
    event_id INT NOT NULL,
    item_name VARCHAR(200) NOT NULL,
    item_price DECIMAL(10,2) NOT NULL CHECK (item_price >= 0),
    created_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (event_id) REFERENCES volunteering_program(event_id) ON DELETE CASCADE
);

-- add index for better performance
CREATE INDEX idx_budget_event ON event_budget_item(event_id);


ALTER TABLE volunteer
DROP COLUMN profile_path;


ALTER TABLE user 
ADD COLUMN profile_path VARCHAR(255) NULL DEFAULT '/V/uploads/profile_image/profile.jpg';

INSERT INTO route_permissions (module, action, allowed_roles) VALUES
('user','uploadProfileImage','volunteer,manager,admin,sponsor,representative,organisationrep');


CREATE TABLE IF NOT EXISTS highlights (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    media_url VARCHAR(500) NOT NULL,
    display_order INT DEFAULT 1,
    status VARCHAR(20) DEFAULT 'active' CHECK (status IN ('active', 'inactive')),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP);

-- INSERT INTO route_permissions (module, action, allowed_roles) VALUES
-- ('admin', 'getallhighlights', 'admin');


ALTER TABLE volunteering_program 
ADD COLUMN peer_rating_open_until DATETIME DEFAULT NULL,
ADD COLUMN points_processed TINYINT(1) DEFAULT 0;


ALTER TABLE item ADD COLUMN image_path VARCHAR(255) DEFAULT NULL;



INSERT INTO route_permissions (module, action, allowed_roles) VALUES
('sponsorship', 'sendsponsorship','sponsor'),
('sponsorship', 'initiatepayment','sponsor'),
('sponsorship', 'sponsorsuccess','sponsor'),
('sponsorship', 'payherenotify','public');
-- this needs to be public to obtain the transaction ID

INSERT INTO route_permissions (module, action, allowed_roles) 
VALUES ('donation', 'initiatepayment', 'volunteer,sponsor');


UPDATE route_permissions 
SET allowed_roles = 'public' 
WHERE module = 'donation' AND action = 'payherenotify';


ALTER TABLE sponsor_event_commitment 
ADD COLUMN order_id VARCHAR(50) AFTER event_id,
ADD COLUMN transaction_id VARCHAR(50) AFTER commitment_amount;

-- remove the NOT NULL
ALTER TABLE sponsor 
  MODIFY COLUMN business_registration_number VARCHAR(50) NULL,
  MODIFY COLUMN year_established YEAR NULL,
  MODIFY COLUMN contact_person_name VARCHAR(100) NULL,
  MODIFY COLUMN contact_person_role VARCHAR(100) NULL,
  MODIFY COLUMN contact_person_email VARCHAR(150) NULL,
  MODIFY COLUMN contact_person_contact_number VARCHAR(20) NULL;


ALTER TABLE sponsor_event_commitment 
DROP INDEX sponsor_id;
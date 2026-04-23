CREATE SCHEMA IF NOT EXISTS V;
USE V;
#--Main User Table
CREATE TABLE IF NOT EXISTS user (
    userid INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,  
    email VARCHAR(100) NOT NULL UNIQUE,
    contactnumber VARCHAR(10),
    role VARCHAR(20) NOT NULL CHECK (role IN ('volunteer', 'manager', 'admin', 'sponsor', 'representative','organisationrep')),
    createddate DATETIME DEFAULT CURRENT_TIMESTAMP
);
#--Role Tables
CREATE TABLE IF NOT EXISTS volunteer (
    userid INT PRIMARY KEY,
    levelpoints INT DEFAULT 0 CHECK (levelpoints >= 0),
    starpoints INT DEFAULT 0 CHECK (starpoints >= 0),
    noofmembers INT DEFAULT 1,
    dob DATE,
    QR VARCHAR(255) NULL,
    FOREIGN KEY (userid) REFERENCES user(userid) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS manager (
    userid INT PRIMARY KEY,
    FOREIGN KEY (userid) REFERENCES user(userid) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS admin (
    userid INT PRIMARY KEY,
    FOREIGN KEY (userid) REFERENCES user(userid) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS sponsor (
    userid INT PRIMARY KEY,
    FOREIGN KEY (userid) REFERENCES user(userid) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS representative (
    userid INT PRIMARY KEY,
    duration INT CHECK (duration > 0),  -- duration in months
    appointeddate DATE,
    FOREIGN KEY (userid) REFERENCES user(userid) ON DELETE CASCADE
);


#--volunteer related tables
CREATE TABLE IF NOT EXISTS volunteer_availability (
    userid INT,
    availability VARCHAR(100) NOT NULL,
    PRIMARY KEY (userid, availability),
    FOREIGN KEY (userid) REFERENCES volunteer(userid) ON DELETE CASCADE
);
CREATE TABLE IF NOT EXISTS volunteer_skill (
    userid INT,
    skill VARCHAR(100) NOT NULL,
    PRIMARY KEY (userid, skill),
    FOREIGN KEY (userid) REFERENCES volunteer(userid) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS volunteer_disability (
    userid INT,
    disability VARCHAR(100) NOT NULL,
    PRIMARY KEY (userid, disability),
    FOREIGN KEY (userid) REFERENCES volunteer(userid) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS volunteer_badge (
    badge_id INT AUTO_INCREMENT PRIMARY KEY,
    userid INT NOT NULL,
    badgeearned VARCHAR(100) NOT NULL,
    earneddate DATE DEFAULT (CURRENT_DATE),
    FOREIGN KEY (userid) REFERENCES volunteer(userid) ON DELETE CASCADE
);

#--event related tables
CREATE TABLE IF NOT EXISTS volunteering_program (
    event_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    event_type VARCHAR(50) NOT NULL,
    state_of_event VARCHAR(50) DEFAULT 'planned' CHECK (state_of_event IN ('planned', 'active', 'completed', 'cancelled')),
    is_annual BOOLEAN DEFAULT FALSE,
    starpoints_reward INT DEFAULT 0 CHECK (starpoints_reward >= 0),
    levelpoints_reward INT DEFAULT 0 CHECK (levelpoints_reward >= 0),
    event_date DATE NOT NULL,
    location VARCHAR(200),
    scale VARCHAR(50) CHECK (scale IN ('small', 'medium', 'large')),
    max_participants INT,
    current_participants INT DEFAULT 0,
    organizer_id INT NOT NULL,  -- manager or representative
    createddate DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (organizer_id) REFERENCES user(userid),
    CHECK (current_participants <= max_participants),
    CHECK (current_participants >= 0)
);
CREATE TABLE IF NOT EXISTS task (
    task_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    status VARCHAR(50) DEFAULT 'pending' CHECK (status IN ('pending', 'inprogress', 'completed', 'cancelled')),
    event_id INT, 
    max_participants INT,
    current_participants INT DEFAULT 0,
    organizer_id INT NOT NULL,  -- manager or representative
    createddate DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (organizer_id) REFERENCES user(userid),
    FOREIGN KEY (event_id) REFERENCES volunteering_program(event_id),
    CHECK (current_participants <= max_participants),
    CHECK (current_participants >= 0)
);
CREATE TABLE IF NOT EXISTS task_assignment (
    task_id INT,
    volunteer_id INT,
    assignment_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (task_id, volunteer_id),
    FOREIGN KEY (task_id) REFERENCES task(task_id) ON DELETE CASCADE,
    FOREIGN KEY (volunteer_id) REFERENCES volunteer(userid) ON DELETE CASCADE
);

#--rating tables
CREATE TABLE IF NOT EXISTS peer_rating (
    peer_ratingid INT AUTO_INCREMENT PRIMARY KEY,
    peer_rating_score DECIMAL(5,2) NOT NULL,
    comment TEXT,
    rater_id INT NOT NULL,
    ratee_id INT NOT NULL,
    event_id INT,
    time_stamp DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY (rater_id, ratee_id, event_id),
    FOREIGN KEY (rater_id) REFERENCES user(userid),
    FOREIGN KEY (ratee_id) REFERENCES user(userid),
    FOREIGN KEY (event_id) REFERENCES volunteering_program(event_id),
    CHECK (rater_id != ratee_id)
);



CREATE TABLE IF NOT EXISTS task_performance_rating (
    taskratingid INT AUTO_INCREMENT PRIMARY KEY,
    task_id INT NOT NULL,
    volunteer_id INT NOT NULL,
    rater_id INT NOT NULL,  -- organizer who rates
    performance_score DECIMAL(5,2) NOT NULL,
    time_stamp DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY (task_id, volunteer_id, rater_id),
    FOREIGN KEY (task_id) REFERENCES task(task_id),
    FOREIGN KEY (volunteer_id) REFERENCES volunteer(userid),
    FOREIGN KEY (rater_id) REFERENCES user(userid)
);
CREATE TABLE IF NOT EXISTS attendance_rating (
    attendance_rating_id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT NOT NULL,
    volunteer_id INT NOT NULL,
    rater_id INT NOT NULL,  -- manager or representative who gives the rating
    attendance_score DECIMAL(5,2) NOT NULL,
    rating_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY (event_id, volunteer_id, rater_id),
    FOREIGN KEY (event_id) REFERENCES volunteering_program(event_id),
    FOREIGN KEY (volunteer_id) REFERENCES volunteer(userid),
    FOREIGN KEY (rater_id) REFERENCES user(userid)
);


CREATE TABLE IF NOT EXISTS event_participation (
    event_id INT,
    volunteer_id INT,
    participation_status VARCHAR(20) DEFAULT 'registered' CHECK (participation_status IN ('registered', 'attended', 'completed', 'cancelled')),
    registration_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (event_id, volunteer_id),
    FOREIGN KEY (event_id) REFERENCES volunteering_program(event_id) ON DELETE CASCADE,
    FOREIGN KEY (volunteer_id) REFERENCES volunteer(userid) ON DELETE CASCADE
);

#--donation related tables
CREATE TABLE IF NOT EXISTS item (
    itemid INT PRIMARY KEY AUTO_INCREMENT,
    itemtype VARCHAR(50) NOT NULL,
    quantity INT DEFAULT 0 CHECK (quantity >= 0),
    managinguserid INT NULL, 
    FOREIGN KEY (managinguserid) REFERENCES user(userid)
);


CREATE TABLE IF NOT EXISTS donation (
    donationid INT PRIMARY KEY AUTO_INCREMENT,
    donationdate DATE NOT NULL,
    receivedamount DECIMAL(12,2) NOT NULL CHECK (receivedamount > 0),
    currentamount DECIMAL(12,2) NOT NULL CHECK (currentamount >= 0),
    sponsorid INT ,
    volunteer_id INT,
    FOREIGN KEY (sponsorid) REFERENCES sponsor(userid) ON DELETE CASCADE,
    FOREIGN KEY (volunteer_id) REFERENCES volunteer(userid) ON DELETE CASCADE,
    CHECK (currentamount <= receivedamount)
);


CREATE TABLE IF NOT EXISTS item_purchase_log (
    log_id INT AUTO_INCREMENT PRIMARY KEY,
    volunteer_id INT NOT NULL,
    itemid INT NOT NULL,
    quantity_taken INT NOT NULL,
    purchase_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (volunteer_id) REFERENCES volunteer(userid) ON DELETE CASCADE,
    FOREIGN KEY (itemid) REFERENCES item(itemid) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS donation_usage (
    usage_id INT PRIMARY KEY AUTO_INCREMENT,
    donationid INT,
    event_id INT,
    manager_id INT NOT NULL,
    used_amount DECIMAL(12,2) NOT NULL CHECK (used_amount > 0),
    usage_date DATE DEFAULT (CURRENT_DATE),
    purpose TEXT,
    FOREIGN KEY (donationid) REFERENCES donation(donationid),
    FOREIGN KEY (event_id) REFERENCES volunteering_program(event_id),
    FOREIGN KEY (manager_id) REFERENCES manager(userid)
);



CREATE TABLE IF NOT EXISTS announcement (
    announcement_id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(200) NOT NULL,
    message TEXT NOT NULL,
    event_id INT NULL,
    announcement_date DATE DEFAULT (CURRENT_DATE),
    announcement_time TIME DEFAULT (CURRENT_TIME),
    is_urgent BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (event_id) REFERENCES volunteering_program(event_id)
);
CREATE TABLE IF NOT EXISTS request (
    request_id INT PRIMARY KEY AUTO_INCREMENT,
    date DATE DEFAULT (CURRENT_DATE),
    description TEXT NOT NULL,
    status VARCHAR(20) DEFAULT 'pending' CHECK (status IN ('pending', 'approved', 'rejected', 'inprogress', 'completed')),
    requester_volunteer_id INT,
    handler_representative_id INT,
    approver_manager_id INT,
    FOREIGN KEY (requester_volunteer_id) REFERENCES volunteer(userid),
    FOREIGN KEY (handler_representative_id) REFERENCES representative(userid),
    FOREIGN KEY (approver_manager_id) REFERENCES manager(userid)
);

CREATE TABLE IF NOT EXISTS sponsorship_request (
    request_id INT PRIMARY KEY,
    event_id INT NOT NULL,
    sponsorid INT NOT NULL,
    FOREIGN KEY (request_id) REFERENCES request(request_id) ON DELETE CASCADE,
    FOREIGN KEY (event_id) REFERENCES volunteering_program(event_id),
    FOREIGN KEY (sponsorid) REFERENCES sponsor(userid)
);


-- Create indexes for better performance
-- CREATE INDEX idx_user_email ON user(email);
-- CREATE INDEX idx_user_role ON user(role);
-- CREATE INDEX idx_volunteer_points ON volunteer(levelpoints, starpoints);
-- CREATE INDEX idx_event_date ON volunteering_program(event_date);
-- CREATE INDEX idx_donation_date ON donation(donationdate);
-- CREATE INDEX idx_task_status ON task(status);
-- CREATE INDEX idx_announcement_date ON announcement(announcement_date);

USE V;
INSERT INTO user (userid, name, password, email, contactnumber, role)
VALUES 
(101, 'Volunteer1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'volunteer1@gmail.com', '0771111101', 'volunteer'),
(102, 'Volunteer2', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'volunteer2@gmail.com', '0771111102', 'volunteer'),
(103, 'Manager1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'manager1@gmail.com', '0771111103', 'manager'),
(104, 'Manager2', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'manager2@gmail.com', '0771111104', 'manager'),
(105, 'Admin1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin1@gmail.com', '0771111105', 'admin'),
(106, 'Sponsor1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'sponsor1@gmail.com', '0771111106', 'sponsor'),
(107, 'Sponsor2', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'sponsor2@gmail.com', '0771111107', 'sponsor'),
(108, 'Representative1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'representative1@gmail.com', '0771111108', 'representative'),
(109, 'Representative2', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'representative2@gmail.com', '0771111109', 'representative'),
(110, 'Volunteer3', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'volunteer3@gmail.com', '0771111110', 'volunteer');

-- Volunteers (with alterations: volunteer_experience, preferred_location_1, preferred_location_2, preferred_location_3)
INSERT INTO volunteer (userid, levelpoints, starpoints, noofmembers, dob, QR, volunteer_experience, preferred_location_1, preferred_location_2, preferred_location_3)
VALUES 
(101, 150, 75, 1, '1995-03-15', 'QR_VOL_101', '2 years of beach cleanup experience', 'Colombo', 'Galle', 'Kandy'),
(102, 200, 100, 2, '1998-07-22', 'QR_VOL_102', '3 years of tree planting campaigns', 'Anuradhapura', 'Jaffna', 'Negombo'),
(110, 50, 25, 1, '2000-11-10', 'QR_VOL_110', 'New volunteer eager to learn', 'Kandy', 'Colombo', 'Galle');


-- Managers
INSERT INTO manager (userid) 
VALUES (103), (104);

-- Admins
INSERT INTO admin (userid) 
VALUES (105);

-- Sponsors
INSERT INTO sponsor (userid) 
VALUES (106), (107);

-- Representatives
INSERT INTO representative (userid, duration, appointeddate)
VALUES 
(108, 12, '2024-01-15'),
(109, 6, '2024-06-01');

-- Volunteer Availability (Format: Day-TimeOfDay)
INSERT INTO volunteer_availability (userid, availability)
VALUES 
(101, 'Mon-Morning'),
(101, 'Sat-Afternoon'),
(101, 'Sun-Morning'),
(102, 'Fri-Evening'),
(102, 'Sat-Morning'),
(102, 'Sun-Afternoon'),
(110, 'Mon-Morning'),
(110, 'Wed-Afternoon'),
(110, 'Sat-Evening');

-- Volunteer Skills
INSERT INTO volunteer_skill (userid, skill)
VALUES 
(101, 'Event Planning'),
(101, 'First Aid'),
(102, 'Photography'),
(102, 'Social Media'),
(110, 'Teaching');

-- Volunteer Disabilities (if any)
INSERT INTO volunteer_disability (userid, disability)
VALUES 
(102, 'Mobility impairment');

-- Volunteer Badges
INSERT INTO volunteer_badge (userid, badgeearned, earneddate)
VALUES 
(101, 'Wave Saver', '2024-01-20'),
(101, 'Coral Guardian', '2024-03-15'),
(102, 'Forest Builder', '2024-02-10'),
(102, 'Peak Protector', '2024-04-05');


-- VOLUNTEERING PROGRAMS / EVENTS
-- (With alterations: duration, time)
INSERT INTO volunteering_program (event_id, name, description, event_type, state_of_event, 
                                  is_annual, starpoints_reward, levelpoints_reward, 
                                  event_date, time, location, scale, max_participants, 
                                  current_participants, organizer_id, duration)
VALUES 
(101, 'Annual Beach Cleanup', 'Beach cleanup at Mount Lavinia', 'Beach Cleanup', 'planned', 
 1, 10, 20, '2025-12-05', '07:00:00', 'Mount Lavinia Beach', 'medium', 50, 0, 103, 3),
 
(102, 'Coral Reef Conservation - Hikkaduwa', 'Participate in coral restoration activities.', 'Coral Restoration', 'active', 
 0, 15, 25, '2025-11-15', '08:00:00', 'Hikkaduwa Marine Park', 'large', 100, 0, 108, 5),
 
(103, 'Tree Planting Campaign - Kandy', 'Participate in reforestation efforts by planting native tree species.', 'Tree Planting', 'planned', 
 1, 20, 30, '2025-12-20', '07:30:00', 'Udawattekele Forest', 'large', 80, 0, 104, 4),
 
(104, 'Mangrove Restoration - Negombo', 'Help us restore the mangrove wetlands of Negombo.', 'Mangrove Restoration', 'completed', 
 0, 12, 18, '2025-10-10', '09:00:00', 'Puttalam Lagoon', 'small', 20, 20, 109, 2),
 
(105, 'Knuckles - Corbett Gap', 'Help us clean the trekking trail towards the Knuckles Mountain Range.', 'Mountain Cleanup', 'planned', 
 0, 25, 40, '2025-11-25', '08:30:00', 'Hunnasgiriya', 'medium', 40, 0, 103, 5);



-- TASKS - Aligned with Events


-- Event 101: Annual Beach Cleanup (3 hours, medium scale, 50 participants)
INSERT INTO task (task_id, name, description, status, event_id, max_participants, current_participants, organizer_id)
VALUES 
(101, 'Setup Collection Points', 'Set up waste collection stations along the beach', 'pending', 101, 8, 0, 103),
(102, 'Beach Zone A Cleanup', 'Clean northern section of Mount Lavinia Beach', 'pending', 101, 15, 0, 103),
(103, 'Beach Zone B Cleanup', 'Clean southern section of Mount Lavinia Beach', 'pending', 101, 15, 0, 103),
(104, 'Waste Sorting & Recording', 'Sort collected waste and record types/quantities', 'pending', 101, 8, 0, 103),
(105, 'Photography & Documentation', 'Document the cleanup process and results', 'pending', 101, 4, 0, 103),

-- Event 102: Coral Reef Conservation - Hikkaduwa (5 hours, large scale, 100 participants)
(106, 'Safety Briefing & Equipment', 'Conduct diving safety briefing and distribute equipment', 'inprogress', 102, 20, 12, 108),
(107, 'Underwater Debris Removal', 'Remove plastic and fishing nets from coral areas', 'inprogress', 102, 25, 15, 108),
(108, 'Coral Fragment Collection', 'Collect healthy coral fragments for restoration', 'inprogress', 102, 15, 10, 108),
(109, 'Coral Transplantation', 'Transplant coral fragments to degraded reef areas', 'pending', 102, 20, 0, 108),
(110, 'Marine Life Survey', 'Document marine species and reef health', 'pending', 102, 10, 0, 108),
(111, 'Community Awareness Session', 'Educate local community about reef conservation', 'pending', 102, 10, 0, 108),

-- Event 103: Tree Planting Campaign - Kandy (4 hours, large scale, 80 participants)
(112, 'Site Preparation', 'Clear planting areas and mark planting spots', 'pending', 103, 20, 0, 104),
(113, 'Dig Planting Holes', 'Dig holes for tree saplings (2ft depth)', 'pending', 103, 25, 0, 104),
(114, 'Sapling Distribution', 'Distribute native tree saplings to volunteers', 'pending', 103, 5, 0, 104),
(115, 'Tree Planting', 'Plant saplings and add fertilizer', 'pending', 103, 25, 0, 104),
(116, 'Watering & Mulching', 'Water newly planted trees and add mulch', 'pending', 103, 5, 0, 104),

-- Event 104: Mangrove Restoration - Negombo (2 hours, small scale, 20 participants, COMPLETED)
(117, 'Mangrove Propagule Collection', 'Collect mangrove propagules from healthy trees', 'completed', 104, 6, 6, 109),
(118, 'Planting in Nursery Beds', 'Plant propagules in designated nursery areas', 'completed', 104, 8, 8, 109),
(119, 'Stake Installation', 'Install protective stakes around planted areas', 'completed', 104, 6, 6, 109),

-- Event 105: Knuckles - Corbett Gap (5 hours, medium scale, 40 participants)
(120, 'Trail Assessment', 'Survey trail condition and mark cleanup zones', 'pending', 105, 6, 0, 103),
(121, 'Litter Collection - Lower Trail', 'Remove litter from lower trekking sections', 'pending', 105, 12, 0, 103),
(122, 'Litter Collection - Upper Trail', 'Remove litter from upper trekking sections', 'pending', 105, 12, 0, 103),
(123, 'Erosion Control Setup', 'Install erosion control measures on steep sections', 'pending', 105, 6, 0, 103),
(124, 'Signage Installation', 'Install environmental awareness signs along trail', 'pending', 105, 4, 0, 103);


-- TASK ASSIGNMENTS

-- Assigned to active/inprogress tasks from Event 102 (Coral Reef Conservation)
-- and completed tasks from Event 104 (Mangrove Restoration)

INSERT INTO task_assignment (task_id, volunteer_id, assignment_date)
VALUES 
-- Event 102 (Active) - Safety Briefing & Equipment (Task 106)
(106, 101, '2025-11-15 07:30:00'),
(106, 102, '2025-11-15 07:30:00'),
(106, 110, '2025-11-15 07:30:00'),

-- Event 102 (Active) - Underwater Debris Removal (Task 107)
(107, 101, '2025-11-15 09:00:00'),
(107, 110, '2025-11-15 09:00:00'),

-- Event 102 (Active) - Coral Fragment Collection (Task 108)
(108, 102, '2025-11-15 09:00:00'),

-- Event 104 (Completed) - Mangrove Propagule Collection (Task 117)
(117, 101, '2025-10-10 09:00:00'),
(117, 102, '2025-10-10 09:00:00'),

-- Event 104 (Completed) - Planting in Nursery Beds (Task 118)
(118, 101, '2025-10-10 10:30:00'),
(118, 110, '2025-10-10 10:30:00'),

-- Event 104 (Completed) - Stake Installation (Task 119)
(119, 102, '2025-10-10 10:30:00'),
(119, 110, '2025-10-10 11:30:00');


-- EVENT PARTICIPATION

INSERT INTO event_participation (event_id, volunteer_id, participation_status, registration_date)
VALUES 
-- Event 101: Annual Beach Cleanup (Planned) - Registered
(101, 101, 'registered', '2025-11-01 14:30:00'),
(101, 102, 'registered', '2025-11-02 10:15:00'),
(101, 110, 'registered', '2025-11-03 16:20:00'),

-- Event 102: Coral Reef Conservation (Active) - Registered/Attended
(102, 101, 'attended', '2025-11-10 08:00:00'),
(102, 102, 'attended', '2025-11-10 08:05:00'),
(102, 110, 'attended', '2025-11-10 08:10:00'),

-- Event 103: Tree Planting Campaign (Planned) - Registered
(103, 101, 'registered', '2025-11-05 16:20:00'),
(103, 102, 'registered', '2025-11-06 10:15:00'),

-- Event 104: Mangrove Restoration (Completed) - Completed
(104, 101, 'completed', '2025-10-08 09:00:00'),
(104, 102, 'completed', '2025-10-08 09:00:00'),
(104, 110, 'completed', '2025-10-08 09:00:00'),

-- Event 105: Knuckles Mountain Cleanup (Planned) - Registered
(105, 101, 'registered', '2025-11-15 14:00:00'),
(105, 110, 'registered', '2025-11-16 11:30:00');

-- RATINGS

-- Peer Ratings
INSERT INTO peer_rating (peer_ratingid, peer_rating_score, comment, rater_id, ratee_id, 
                        event_id, time_stamp)
VALUES 
(101, 4.5, 'Great teamwork and positive attitude!', 102, 101, 102, '2025-11-15 17:00:00'),
(102, 5.0, 'Very helpful and organized', 101, 102, 102, '2025-11-15 17:05:00'),
(103, 4.8, 'Excellent coordination skills', 110, 101, 102, '2025-11-15 17:10:00');

-- Task Performance Ratings
INSERT INTO task_performance_rating (taskratingid, task_id, volunteer_id, rater_id, 
                                    performance_score, time_stamp)
VALUES 
(101, 104, 101, 108, 4.7, '2025-11-15 16:00:00'),
(102, 104, 102, 108, 4.5, '2025-11-15 16:05:00'),
(103, 105, 101, 108, 4.9, '2025-11-15 16:10:00'),
(104, 108, 102, 109, 5.0, '2025-10-10 15:00:00'),
(105, 109, 110, 109, 4.8, '2025-10-10 15:05:00');

-- Attendance Ratings
INSERT INTO attendance_rating (attendance_rating_id, event_id, volunteer_id, rater_id, 
                              attendance_score, rating_date)
VALUES 
(101, 102, 101, 108, 5.0, '2025-11-15 18:00:00'),
(102, 102, 102, 108, 5.0, '2025-11-15 18:00:00'),
(103, 102, 110, 108, 4.8, '2025-11-15 18:00:00'),
(104, 104, 102, 109, 5.0, '2025-10-10 16:00:00'),
(105, 104, 110, 109, 5.0, '2025-10-10 16:00:00');


-- ITEMS (With alterations: emoji, description, price, stock sizes, is_active)
-- ============================================
INSERT INTO item (itemid, itemtype, emoji, description, price, stock_XS, stock_S, stock_M, 
                  stock_L, stock_XL, stock_XXL, is_active, managinguserid)
VALUES 
(101, 'T-Shirt', '👔', 'Premium Quality Beach Event T-shirt', 1000.00, 5, 10, 20, 15, 10, 5, 1, 103),
(105, 'Jersey', '👕', 'Premium Quality Volunteer Jersey', 1500.00, 5, 15, 25, 20, 10, 5, 1, 103);

-- ============================================
-- DONATIONS
-- ============================================
INSERT INTO donation (donationid, donationdate, receivedamount, currentamount, sponsorid, volunteer_id)
VALUES 
(101, '2025-01-15', 100000.00, 85000.00, 106, NULL),
(102, '2025-02-20', 50000.00, 45000.00, 107, NULL),
(103, '2025-03-10', 75000.00, 75000.00, 106, NULL),
(104, '2025-05-05', 5000.00, 5000.00, NULL, 101),
(105, '2025-06-12', 3000.00, 3000.00, NULL, 102);

-- ============================================
-- ITEM PURCHASE LOG
-- ============================================
INSERT INTO item_purchase_log (log_id, volunteer_id, itemid, quantity_taken, purchase_date)
VALUES 
(101, 101, 101, 2, '2025-03-20 10:30:00'),
(102, 101, 102, 1, '2025-03-20 10:30:00'),
(103, 102, 101, 1, '2025-04-15 14:20:00'),
(104, 102, 103, 2, '2025-04-15 14:20:00'),
(105, 110, 101, 1, '2025-05-10 11:00:00');

-- ============================================
-- DONATION USAGE
-- ============================================
INSERT INTO donation_usage (usage_id, donationid, event_id, manager_id, used_amount, 
                           usage_date, purpose)
VALUES 
(101, 101, 102, 103, 15000.00, '2025-11-10', 'Equipments and Gear'),
(102, 102, 104, 104, 5000.00, '2025-10-05', 'Tools and Equipment'),
(103, 101, 105, 103, 10000.00, '2025-11-20', 'Medical supplies and equipment rental');


-- ANNOUNCEMENTS

INSERT INTO announcement (announcement_id, title, message, event_id, announcement_date, 
                         announcement_time, is_urgent)
VALUES 
(101, 'Welcome Message', 
    'Welcome to the volunteer platform test environment!', 
    NULL, '2025-01-01', '00:00:00', 0),
    
(102, 'Beach Cleanup Event', 
    'Registration is now open for our test beach cleanup event!', 
    101, '2025-11-01', '09:00:00', 1),
    
(103, 'Mangrove Restoration Reminder', 
    'Reminder: Mangrove Restoration event starts tomorrow at 8 AM.', 
    102, '2025-11-14', '18:00:00', 1),
    
(104, 'Tree Planting Campaign', 
    'Join us for our test tree planting campaign!', 
    103, '2025-11-10', '10:00:00', 0);

-- REQUESTS (With alterations: type, linkedin)
INSERT INTO request (request_id, date, description, status, requester_volunteer_id, 
                    handler_representative_id, approver_manager_id, type, linkedin)
VALUES 
(101, '2025-10-15', 'Request Sponsor2 to sponsor Mangrove Restoration Program', 
    'approved', NULL, NULL, 103, 'requestforsponsorship', NULL),
    
(102, '2025-10-20', 'Request Sponsor1 to sponsor Tree Planting Event', 
    'completed', NULL, NULL, 103, 'requestforsponsorship', NULL),
    
(103, '2025-11-01', 'Application to become representative', 
    'pending', 101, NULL, NULL, 'applytoberep', 'https://linkedin.com/in/volunteer1'),
    
(104, '2025-11-05', 'Request sponsorship for new beach cleanup event', 
    'pending', NULL, NULL, NULL, 'requesttosponsor', NULL);


-- SPONSORSHIP REQUESTS

INSERT INTO sponsorship_request (request_id, event_id, sponsorid)
VALUES 
(101, 102, 106),
(102, 105, 107);

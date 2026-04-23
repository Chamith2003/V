-- ============================================================
--  V DATABASE - FULL SAMPLE DATA INSERT SCRIPT
--  Password - Password@123
-- ============================================================

USE V;

-- ============================================================
-- 1. USER TABLE
--    IDs 1        → Admin
--    IDs 2        → Manager
--    IDs 3–22     → Sponsors  (20)
--    IDs 23–42    → Representatives (20)
--    IDs 43–44    → Org Representatives (2)
--    IDs 45–94    → Volunteers (50)  [45–49 suspended, rest active]
-- ============================================================

INSERT INTO user (userid, name, password, email, contactnumber, role, status) VALUES

-- Admin (1)
(1,  'Admin User',          '$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK', 'admin@v.org',               '0711000001', 'admin',           'active'),

-- Manager (1)
(2,  'Manager Alex',        '$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK', 'manager@v.org',             '0711000002', 'manager',         'active'),

-- Sponsors (20) — IDs 3-22
(3,  'Sponsor Corp One',    '$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK', 'sponsor1@corp.com',         '0711000003', 'sponsor',         'active'),
(4,  'Sponsor Corp Two',    '$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK', 'sponsor2@corp.com',         '0711000004', 'sponsor',         'active'),
(5,  'Sponsor Corp Three',  '$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK', 'sponsor3@corp.com',         '0711000005', 'sponsor',         'active'),
(6,  'Sponsor Corp Four',   '$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK', 'sponsor4@corp.com',         '0711000006', 'sponsor',         'active'),
(7,  'Sponsor Corp Five',   '$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK', 'sponsor5@corp.com',         '0711000007', 'sponsor',         'active'),
(8,  'Sponsor Corp Six',    '$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK', 'sponsor6@corp.com',         '0711000008', 'sponsor',         'active'),
(9,  'Sponsor Corp Seven',  '$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK', 'sponsor7@corp.com',         '0711000009', 'sponsor',         'active'),
(10, 'Adidas',  '$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK', 'sponsor8@corp.com',         '0711000010', 'sponsor',         'active'),
(11, 'Sponsor Corp Nine',   '$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK', 'sponsor9@corp.com',         '0711000011', 'sponsor',         'active'),
(12, 'Sponsor Corp Ten',    '$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK', 'sponsor10@corp.com',        '0711000012', 'sponsor',         'active'),
(13, 'Sponsor Corp Eleven', '$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK', 'sponsor11@corp.com',        '0711000013', 'sponsor',         'active'),
(14, 'Sponsor Corp Twelve', '$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK', 'sponsor12@corp.com',        '0711000014', 'sponsor',         'active'),
(15, 'Sponsor Corp Thirteen','$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK','sponsor13@corp.com',        '0711000015', 'sponsor',         'active'),
(16, 'Sponsor Corp Fourteen','$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK','sponsor14@corp.com',        '0711000016', 'sponsor',         'active'),
(17, 'Sponsor Corp Fifteen','$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK', 'sponsor15@corp.com',        '0711000017', 'sponsor',         'active'),
(18, 'Sponsor Corp Sixteen','$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK', 'sponsor16@corp.com',        '0711000018', 'sponsor',         'active'),
(19, 'Sponsor Corp Seventeen','$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK','sponsor17@corp.com',       '0711000019', 'sponsor',         'active'),
(20, 'Sponsor Corp Eighteen','$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK','sponsor18@corp.com',        '0711000020', 'sponsor',         'active'),
(21, 'Sponsor Corp Nineteen','$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK','sponsor19@corp.com',        '0711000021', 'sponsor',         'suspended'),
(22, 'Sponsor Corp Twenty', '$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK', 'sponsor20@corp.com',        '0711000022', 'sponsor',         'suspended'),

-- Representatives (20) — IDs 23-42
(23, 'Rep Aiden Silva',     '$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK', 'rep1@v.org',                '0711000023', 'representative',  'active'),
(24, 'Rep Bianca Perera',   '$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK', 'rep2@v.org',                '0711000024', 'representative',  'active'),
(25, 'Rep Carlos Mendez',   '$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK', 'rep3@v.org',                '0711000025', 'representative',  'active'),
(26, 'Rep Diana Gunasekara','$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK', 'rep4@v.org',                '0711000026', 'representative',  'active'),
(27, 'Rep Eric Weerasinghe','$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK', 'rep5@v.org',                '0711000027', 'representative',  'active'),
(28, 'Rep Fiona Jayasuriya','$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK', 'rep6@v.org',                '0711000028', 'representative',  'active'),
(29, 'Rep George Ranasinghe','$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK','rep7@v.org',                '0711000029', 'representative',  'active'),
(30, 'Rep Hannah Bandara',  '$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK', 'rep8@v.org',                '0711000030', 'representative',  'active'),
(31, 'Rep Ivan Dissanayake','$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK', 'rep9@v.org',                '0711000031', 'representative',  'active'),
(32, 'Rep Julia Karunaratne','$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK','rep10@v.org',               '0711000032', 'representative',  'active'),
(33, 'Rep Kevin Wijesekara','$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK', 'rep11@v.org',               '0711000033', 'representative',  'active'),
(34, 'Rep Laura Seneviratne','$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK','rep12@v.org',               '0711000034', 'representative',  'active'),
(35, 'Rep Mike Rajapaksa',  '$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK', 'rep13@v.org',               '0711000035', 'representative',  'active'),
(36, 'Rep Nina Samaraweera','$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK', 'rep14@v.org',               '0711000036', 'representative',  'active'),
(37, 'Rep Oscar Senanayake','$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK', 'rep15@v.org',               '0711000037', 'representative',  'active'),
(38, 'Rep Paula Wickramasinghe','$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK','rep16@v.org',            '0711000038', 'representative',  'active'),
(39, 'Rep Quinn Amarasinghe','$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK','rep17@v.org',               '0711000039', 'representative',  'active'),
(40, 'Rep Rachel Abeywickrama','$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK','rep18@v.org',             '0711000040', 'representative',  'active'),
(41, 'Rep Sam Tissera',     '$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK', 'rep19@v.org',               '0711000041', 'representative',  'suspended'),
(42, 'Rep Tina Herath',     '$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK', 'rep20@v.org',               '0711000042', 'representative',  'suspended'),

-- Org Representatives (2) — IDs 43-44
(43, 'OrgRep Uma Vithanage','$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK', 'orgrep1@v.org',             '0711000043', 'organisationrep', 'active'),
(44, 'OrgRep Victor Nanayakkara','$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK','orgrep2@v.org',         '0711000044', 'organisationrep', 'active'),

-- Volunteers (50) — IDs 45-94
-- IDs 45-49: suspended  |  IDs 50-94: active
(45, 'Vol Amaya Fonseka',   '$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK', 'vol1@gmail.com',            '0711000045', 'volunteer',       'suspended'),
(46, 'Vol Bimal Gunawardena','$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK','vol2@gmail.com',            '0711000046', 'volunteer',       'suspended'),
(47, 'Vol Chamari Alwis',   '$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK', 'vol3@gmail.com',            '0711000047', 'volunteer',       'suspended'),
(48, 'Vol Dilan Munasinghe','$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK', 'vol4@gmail.com',            '0711000048', 'volunteer',       'suspended'),
(49, 'Vol Erandi Madushani','$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK', 'vol5@gmail.com',            '0711000049', 'volunteer',       'suspended'),
(50, 'Vol Fathima Nazeer',  '$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK', 'vol6@gmail.com',            '0711000050', 'volunteer',       'active'),
(51, 'Vol Gehan Kulatunga', '$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK', 'vol7@gmail.com',            '0711000051', 'volunteer',       'active'),
(52, 'Vol Hiruni Dahanayake','$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK','vol8@gmail.com',            '0711000052', 'volunteer',       'active'),
(53, 'Vol Isuru Pathirana', '$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK', 'vol9@gmail.com',            '0711000053', 'volunteer',       'active'),
(54, 'Vol Janani Sivakumar','$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK', 'vol10@gmail.com',           '0711000054', 'volunteer',       'active'),
(55, 'Vol Kasun Premaratne','$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK', 'vol11@gmail.com',           '0711000055', 'volunteer',       'active'),
(56, 'Vol Lakmini Rathnayake','$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK','vol12@gmail.com',          '0711000056', 'volunteer',       'active'),
(57, 'Vol Mahesh Thisera',  '$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK', 'vol13@gmail.com',           '0711000057', 'volunteer',       'active'),
(58, 'Vol Nadeeka Wijetunga','$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK','vol14@gmail.com',           '0711000058', 'volunteer',       'active'),
(59, 'Vol Oshadi Jayawardena','$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK','vol15@gmail.com',          '0711000059', 'volunteer',       'active'),
(60, 'Vol Prabath Kumara',  '$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK', 'vol16@gmail.com',           '0711000060', 'volunteer',       'active'),
(61, 'Vol Qasim Jiffry',    '$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK', 'vol17@gmail.com',           '0711000061', 'volunteer',       'active'),
(62, 'Vol Rashmi Liyanage', '$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK', 'vol18@gmail.com',           '0711000062', 'volunteer',       'active'),
(63, 'Vol Sachini Warnasuriya','$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK','vol19@gmail.com',         '0711000063', 'volunteer',       'active'),
(64, 'Vol Tharindu Samarakoon','$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK','vol20@gmail.com',         '0711000064', 'volunteer',       'active'),
(65, 'Vol Umayangani Peris','$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK', 'vol21@gmail.com',           '0711000065', 'volunteer',       'active'),
(66, 'Vol Vimukthi Gamage', '$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK', 'vol22@gmail.com',           '0711000066', 'volunteer',       'active'),
(67, 'Vol Waruni Rodrigo',  '$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK', 'vol23@gmail.com',           '0711000067', 'volunteer',       'active'),
(68, 'Vol Xeran Marasinghe','$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK', 'vol24@gmail.com',           '0711000068', 'volunteer',       'active'),
(69, 'Vol Yashodha Nandasiri','$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK','vol25@gmail.com',          '0711000069', 'volunteer',       'active'),
(70, 'Vol Zinara Muthumala','$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK', 'vol26@gmail.com',           '0711000070', 'volunteer',       'active'),
(71, 'Vol Anura Senanayake','$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK', 'vol27@gmail.com',           '0711000071', 'volunteer',       'active'),
(72, 'Vol Buddhini Dharmaratne','$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK','vol28@gmail.com',        '0711000072', 'volunteer',       'active'),
(73, 'Vol Chatura Siriwardena','$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK','vol29@gmail.com',         '0711000073', 'volunteer',       'active'),
(74, 'Vol Dilani Wickrama', '$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK', 'vol30@gmail.com',           '0711000074', 'volunteer',       'active'),
(75, 'Vol Eshan Kuruppu',   '$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK', 'vol31@gmail.com',           '0711000075', 'volunteer',       'active'),
(76, 'Vol Faariya Ismail',  '$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK', 'vol32@gmail.com',           '0711000076', 'volunteer',       'active'),
(77, 'Vol Gavesh Ekanayake','$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK', 'vol33@gmail.com',           '0711000077', 'volunteer',       'active'),
(78, 'Vol Hasitha Madanayake','$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK','vol34@gmail.com',          '0711000078', 'volunteer',       'active'),
(79, 'Vol Imasha Senaratne','$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK', 'vol35@gmail.com',           '0711000079', 'volunteer',       'active'),
(80, 'Vol Jayani Koswatte', '$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK', 'vol36@gmail.com',           '0711000080', 'volunteer',       'active'),
(81, 'Vol Krishan Muthukumar','$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK','vol37@gmail.com',          '0711000081', 'volunteer',       'active'),
(82, 'Vol Lakmali Chandrasekara','$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK','vol38@gmail.com',       '0711000082', 'volunteer',       'active'),
(83, 'Vol Malinga Gallage', '$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK', 'vol39@gmail.com',           '0711000083', 'volunteer',       'active'),
(84, 'Vol Nethmi Sooriyaarachchi','$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK','vol40@gmail.com',      '0711000084', 'volunteer',       'active'),
(85, 'Vol Oshan Abeyrathna','$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK', 'vol41@gmail.com',           '0711000085', 'volunteer',       'active'),
(86, 'Vol Praveen Navaratnam','$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK','vol42@gmail.com',          '0711000086', 'volunteer',       'active'),
(87, 'Vol Qudsiya Farook',  '$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK', 'vol43@gmail.com',           '0711000087', 'volunteer',       'active'),
(88, 'Vol Ravindu Amarakoon','$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK','vol44@gmail.com',           '0711000088', 'volunteer',       'active'),
(89, 'Vol Savini Premachandra','$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK','vol45@gmail.com',         '0711000089', 'volunteer',       'active'),
(90, 'Vol Tilan Rajasekara','$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK', 'vol46@gmail.com',           '0711000090', 'volunteer',       'active'),
(91, 'Vol Uthpali Gunasekera','$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK','vol47@gmail.com',          '0711000091', 'volunteer',       'active'),
(92, 'Vol Vidusha Jayasena','$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK', 'vol48@gmail.com',           '0711000092', 'volunteer',       'active'),
(93, 'Vol Wathsala Mendis', '$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK', 'vol49@gmail.com',           '0711000093', 'volunteer',       'active'),
(94, 'Vol Xeniya Saman',    '$2y$10$dut7HU3SDpHEB/2WcsXXGurRVUWRbISHGEQtliF/sPEsNq1.8wEDK', 'vol50@gmail.com',           '0711000094', 'volunteer',       'active');


-- ============================================================
-- 2. ROLE TABLES
-- ============================================================

-- Admin
INSERT INTO admin (userid) VALUES (1);

-- Manager
INSERT INTO manager (userid) VALUES (2);

-- Sponsors (IDs 3-22) with extra columns from V_Alterations.sql
INSERT INTO sponsor (userid, business_registration_number, year_established, official_website_link, about_company, organization_type, contact_person_name, contact_person_role, contact_person_email, contact_person_contact_number) VALUES
(3,  'BRN-0001', 2010, 'https://sponsorcorp1.com',  'Green energy solutions provider.',           'Private Limited', 'Alice Brown',    'CEO',           'alice@sponsorcorp1.com',   '0712000003'),
(4,  'BRN-0002', 2008, 'https://sponsorcorp2.com',  'Leading textile manufacturer.',              'Private Limited', 'Bob Carter',     'CFO',           'bob@sponsorcorp2.com',     '0712000004'),
(5,  'BRN-0003', 2015, 'https://sponsorcorp3.com',  'Tech startup specialising in AI.',           'Startup',         'Carol Davis',    'CTO',           'carol@sponsorcorp3.com',   '0712000005'),
(6,  'BRN-0004', 2000, 'https://sponsorcorp4.com',  'Real estate and construction firm.',         'PLC',             'David Evans',    'Director',      'david@sponsorcorp4.com',   '0712000006'),
(7,  'BRN-0005', 2005, 'https://sponsorcorp5.com',  'Food & beverage multinational.',             'PLC',             'Eve Foster',     'VP Marketing',  'eve@sponsorcorp5.com',     '0712000007'),
(8,  'BRN-0006', 2012, 'https://sponsorcorp6.com',  'Healthcare and pharma distributor.',         'Private Limited', 'Frank Green',    'COO',           'frank@sponsorcorp6.com',   '0712000008'),
(9,  'BRN-0007', 1998, 'https://sponsorcorp7.com',  'Banking and finance institution.',           'PLC',             'Grace Hall',     'MD',            'grace@sponsorcorp7.com',   '0712000009'),
(10, 'BRN-0008', 2018, 'https://sponsorcorp8.com',  'Logistics and supply chain company.',        'Private Limited', 'Henry Irving',   'GM',            'henry@sponsorcorp8.com',   '0712000010'),
(11, 'BRN-0009', 2003, 'https://www.adidas.com/us',  'Quality shoe company',             'PLC',             'Iris James',     'Director',      'iris@sponsorcorp9.com',    '0712000011'),
(12, 'BRN-0010', 2011, 'https://sponsorcorp10.com', 'Retail chain and e-commerce.',               'Private Limited', 'Jack King',      'CEO',           'jack@sponsorcorp10.com',   '0712000012'),
(13, 'BRN-0011', 2007, 'https://sponsorcorp11.com', 'Educational publishing house.',              'NGO',             'Karen Lee',      'Chairperson',   'karen@sponsorcorp11.com',  '0712000013'),
(14, 'BRN-0012', 2016, 'https://sponsorcorp12.com', 'Renewable energy consultancy.',              'Startup',         'Leo Martin',     'Founder',       'leo@sponsorcorp12.com',    '0712000014'),
(15, 'BRN-0013', 2001, 'https://sponsorcorp13.com', 'Insurance and risk management.',             'PLC',             'Mia Nelson',     'CFO',           'mia@sponsorcorp13.com',    '0712000015'),
(16, 'BRN-0014', 2013, 'https://sponsorcorp14.com', 'Software development firm.',                 'Private Limited', 'Nick Owen',      'CTO',           'nick@sponsorcorp14.com',   '0712000016'),
(17, 'BRN-0015', 2009, 'https://sponsorcorp15.com', 'Agriculture and agro-processing.',           'Cooperative',     'Olivia Park',    'GM',            'olivia@sponsorcorp15.com', '0712000017'),
(18, 'BRN-0016', 2019, 'https://sponsorcorp16.com', 'Media and communications group.',            'PLC',             'Paul Quinn',     'MD',            'paul@sponsorcorp16.com',   '0712000018'),
(19, 'BRN-0017', 2004, 'https://sponsorcorp17.com', 'Construction materials manufacturer.',       'Private Limited', 'Rachel Rose',    'Director',      'rachel@sponsorcorp17.com', '0712000019'),
(20, 'BRN-0018', 2014, 'https://sponsorcorp18.com', 'Automotive parts and services.',             'Private Limited', 'Sam Stone',      'CEO',           'sam@sponsorcorp18.com',    '0712000020'),
(21, 'BRN-0019', 2006, 'https://sponsorcorp19.com', 'Marine and shipping services.',              'PLC',             'Tara Turner',    'COO',           'tara@sponsorcorp19.com',   '0712000021'),
(22, 'BRN-0020', 2017, 'https://sponsorcorp20.com', 'Waste management and recycling.',            'NGO',             'Uma Underwood',  'Director',      'uma@sponsorcorp20.com',    '0712000022');

-- Representatives (IDs 23-42)
INSERT INTO representative (userid, duration, appointeddate, isorgrep, is_active) VALUES
(23, 12, '2024-01-15', 0, 1),
(24, 12, '2024-01-15', 0, 1),
(25, 12, '2024-02-01', 0, 1),
(26, 12, '2024-02-01', 0, 1),
(27, 12, '2024-02-15', 0, 1),
(28, 12, '2024-02-15', 0, 1),
(29, 12, '2024-03-01', 0, 1),
(30, 12, '2024-03-01', 0, 1),
(31, 12, '2024-03-15', 0, 1),
(32, 12, '2024-03-15', 0, 1),
(33, 12, '2024-04-01', 0, 1),
(34, 12, '2024-04-01', 0, 1),
(35, 12, '2024-04-15', 0, 1),
(36, 12, '2024-04-15', 0, 1),
(37, 12, '2024-05-01', 0, 1),
(38, 12, '2024-05-01', 0, 1),
(39, 12, '2024-05-15', 0, 1),
(40, 12, '2024-05-15', 0, 1),
(41, 12, '2024-06-01', 0, 0),  -- suspended
(42, 12, '2024-06-01', 0, 0);  -- suspended

-- Org Representatives (IDs 43-44)
INSERT INTO org_representative (userid, duration, appointeddate, is_active) VALUES
(43, 24, '2023-06-01', 1),
(44, 24, '2023-06-01', 1);

-- Volunteers (IDs 45-94)
INSERT INTO volunteer (userid, levelpoints, starpoints, noofmembers, dob, volunteer_experience, preferred_location_1, preferred_location_2, preferred_location_3) VALUES
(45,  120, 30,  1, '1998-04-12', '2 years beach cleanups',           'Colombo',    'Galle',      'Negombo'),
(46,  80,  20,  1, '2000-07-23', '1 year tree planting',             'Kandy',      'Colombo',    'Matara'),
(47,  200, 55,  2, '1995-11-05', '3 years coral restoration',        'Galle',      'Hikkaduwa',  'Unawatuna'),
(48,  50,  10,  1, '2002-03-18', 'New volunteer',                    'Colombo',    'Negombo',    NULL),
(49,  310, 80,  3, '1990-09-30', '5 years various programmes',       'Colombo',    'Galle',      'Jaffna'),
(50,  150, 40,  1, '1997-06-14', '2 years city cleanups',            'Colombo',    'Dehiwala',   'Nugegoda'),
(51,  90,  25,  1, '2001-01-28', '1 year mangrove restoration',      'Negombo',    'Puttalam',   NULL),
(52,  400, 100, 4, '1988-12-10', '7 years senior volunteer',         'Colombo',    'Kandy',      'Galle'),
(53,  60,  15,  1, '2003-08-02', 'First year volunteer',             'Gampaha',    'Colombo',    NULL),
(54,  220, 60,  2, '1994-05-19', '4 years mountain cleanups',        'Kandy',      'Nuwara Eliya','Badulla'),
(55,  180, 45,  1, '1999-10-07', '3 years coral restoration',        'Galle',      'Hikkaduwa',  'Weligama'),
(56,  75,  18,  1, '2002-02-14', '1 year tree planting',             'Colombo',    'Gampaha',    NULL),
(57,  350, 90,  3, '1991-07-27', '6 years all types',                'Colombo',    'Galle',      'Trincomalee'),
(58,  130, 35,  1, '1998-09-03', '2 years beach cleanups',           'Negombo',    'Colombo',    'Puttalam'),
(59,  95,  22,  1, '2000-04-16', '1.5 years city cleanups',          'Colombo',    'Dehiwala',   NULL),
(60,  270, 70,  2, '1993-11-29', '4 years mangrove work',            'Puttalam',   'Negombo',    'Trincomalee'),
(61,  40,  8,   1, '2004-06-08', 'New volunteer',                    'Colombo',    NULL,         NULL),
(62,  160, 42,  1, '1997-03-21', '2.5 years various',                'Gampaha',    'Colombo',    'Kandy'),
(63,  230, 62,  2, '1994-08-14', '4 years beach and coral',          'Galle',      'Matara',     'Hambantota'),
(64,  110, 28,  1, '1999-01-05', '2 years mountain cleanups',        'Kandy',      'Matale',     'Nuwara Eliya'),
(65,  195, 50,  2, '1996-12-17', '3 years tree planting',            'Colombo',    'Gampaha',    'Kurunegala'),
(66,  85,  21,  1, '2001-05-30', '1 year coral restoration',         'Galle',      'Hikkaduwa',  NULL),
(67,  290, 75,  3, '1992-09-22', '5 years all programmes',           'Colombo',    'Galle',      'Kandy'),
(68,  55,  12,  1, '2003-02-09', 'New volunteer',                    'Negombo',    'Colombo',    NULL),
(69,  140, 38,  1, '1998-07-01', '2 years beach cleanups',           'Matara',     'Galle',      'Hambantota'),
(70,  210, 58,  2, '1995-04-25', '3 years mangrove restoration',     'Puttalam',   'Negombo',    'Chilaw'),
(71,  100, 26,  1, '2000-10-13', '1.5 years city cleanups',          'Colombo',    'Nugegoda',   'Dehiwala'),
(72,  320, 82,  3, '1990-06-06', '6 years senior volunteer',         'Colombo',    'Kandy',      'Galle'),
(73,  70,  16,  1, '2002-11-19', '1 year tree planting',             'Kandy',      'Matale',     NULL),
(74,  175, 46,  1, '1997-08-08', '3 years coral and beach',          'Galle',      'Unawatuna',  'Hikkaduwa'),
(75,  245, 64,  2, '1993-03-31', '4 years mountain cleanups',        'Kandy',      'Nuwara Eliya','Ella'),
(76,  65,  14,  1, '2003-12-24', 'New volunteer',                    'Colombo',    'Gampaha',    NULL),
(77,  385, 96,  4, '1988-05-17', '8 years all types, team leader',   'Colombo',    'Galle',      'Kandy'),
(78,  115, 29,  1, '1999-07-10', '2 years city cleanups',            'Gampaha',    'Colombo',    NULL),
(79,  165, 44,  1, '1997-02-03', '2.5 years beach cleanups',         'Negombo',    'Colombo',    'Puttalam'),
(80,  255, 66,  2, '1993-09-16', '4 years mangrove work',            'Puttalam',   'Chilaw',     'Negombo'),
(81,  45,  9,   1, '2004-04-29', 'New volunteer',                    'Colombo',    NULL,         NULL),
(82,  185, 48,  2, '1996-11-12', '3 years all programmes',           'Colombo',    'Kandy',      'Galle'),
(83,  105, 27,  1, '2000-08-25', '1.5 years tree planting',          'Kurunegala', 'Colombo',    'Kandy'),
(84,  275, 72,  3, '1992-01-18', '5 years coral restoration',        'Galle',      'Hikkaduwa',  'Matara'),
(85,  135, 36,  1, '1998-06-01', '2 years mountain cleanups',        'Kandy',      'Nuwara Eliya',NULL),
(86,  225, 59,  2, '1994-10-14', '3.5 years various',                'Colombo',    'Gampaha',    'Negombo'),
(87,  80,  19,  1, '2001-03-07', '1 year beach cleanups',            'Matara',     'Galle',      NULL),
(88,  305, 78,  3, '1991-12-20', '5 years all types',                'Colombo',    'Galle',      'Trincomalee'),
(89,  145, 39,  1, '1998-05-13', '2 years mangrove restoration',     'Negombo',    'Puttalam',   'Chilaw'),
(90,  215, 56,  2, '1995-09-26', '3 years city and beach',           'Colombo',    'Dehiwala',   'Galle'),
(91,  70,  17,  1, '2002-07-09', '1 year tree planting',             'Gampaha',    'Colombo',    NULL),
(92,  260, 67,  2, '1993-02-22', '4 years all programmes',           'Colombo',    'Kandy',      'Galle'),
(93,  125, 33,  1, '1999-11-15', '2 years coral restoration',        'Galle',      'Hikkaduwa',  'Unawatuna'),
(94,  340, 87,  3, '1990-04-28', '6 years senior volunteer',         'Colombo',    'Galle',      'Kandy');


-- ============================================================
-- 3. VOLUNTEER SKILLS, AVAILABILITY, DISABILITIES
-- ============================================================

INSERT INTO volunteer_skill (userid, skill) VALUES
(50, 'Diving'), (50, 'Marine Biology'),
(51, 'Horticulture'), (51, 'First Aid'),
(52, 'Leadership'), (52, 'Scuba Diving'), (52, 'Project Management'),
(53, 'Gardening'),
(54, 'Hiking'), (54, 'Rope Climbing'),
(55, 'Coral Restoration'), (55, 'Snorkeling'),
(56, 'Planting'), (56, 'Landscaping'),
(57, 'Leadership'), (57, 'All-terrain driving'), (57, 'Waste Management'),
(58, 'Swimming'), (58, 'Beach Cleanup'),
(59, 'Photography'), (59, 'Social Media'),
(60, 'Mangrove Restoration'), (60, 'Boat Handling'),
(62, 'Teaching'), (62, 'Communication'),
(63, 'Marine Research'), (63, 'Snorkeling'),
(64, 'Mountain Navigation'), (64, 'First Aid'),
(65, 'Tree Identification'), (65, 'Nursery Management'),
(67, 'Leadership'), (67, 'Waste Sorting'), (67, 'Community Outreach'),
(70, 'Mangrove Planting'), (70, 'GIS Mapping'),
(72, 'Leadership'), (72, 'Training'), (72, 'Event Coordination'),
(74, 'Marine Biology'), (74, 'Underwater Photography'),
(75, 'Hiking'), (75, 'Wildlife Monitoring'),
(77, 'Leadership'), (77, 'Safety Training'), (77, 'Multi-sport'),
(80, 'Wetland Ecology'), (80, 'Bird Watching'),
(82, 'Community Engagement'), (82, 'Social Work'),
(84, 'Coral Research'), (84, 'Diving Instructor'),
(86, 'Event Planning'), (86, 'Logistics'),
(88, 'Leadership'), (88, 'Marine Conservation'),
(90, 'Urban Ecology'), (90, 'Waste Management'),
(92, 'Volunteer Training'), (92, 'Field Research'),
(94, 'Senior Leadership'), (94, 'Programme Design');



INSERT INTO volunteer_availability (userid, availability) VALUES

-- ── ID 23  Rep Aiden Silva ──────────────────────────────────
(23, 'Mon-Morning'),
(23, 'Wed-Afternoon'),
(23, 'Fri-Evening'),

-- ── ID 24  Rep Bianca Perera ────────────────────────────────
(24, 'Tue-Morning'),
(24, 'Thu-Afternoon'),
(24, 'Sat-Morning'),

-- ── ID 25  Rep Carlos Mendez ────────────────────────────────
(25, 'Mon-Afternoon'),
(25, 'Wed-Morning'),
(25, 'Sun-Evening'),

-- ── ID 26  Rep Diana Gunasekara ─────────────────────────────
(26, 'Tue-Evening'),
(26, 'Fri-Morning'),
(26, 'Sat-Afternoon'),

-- ── ID 27  Rep Eric Weerasinghe ─────────────────────────────
(27, 'Mon-Morning'),
(27, 'Thu-Morning'),
(27, 'Sat-Evening'),

-- ── ID 28  Rep Fiona Jayasuriya ─────────────────────────────
(28, 'Wed-Morning'),
(28, 'Fri-Afternoon'),
(28, 'Sun-Morning'),

-- ── ID 29  Rep George Ranasinghe ────────────────────────────
(29, 'Tue-Afternoon'),
(29, 'Thu-Evening'),
(29, 'Sat-Morning'),

-- ── ID 30  Rep Hannah Bandara ───────────────────────────────
(30, 'Mon-Evening'),
(30, 'Wed-Afternoon'),
(30, 'Fri-Morning'),
(30, 'Sun-Afternoon'),

-- ── ID 31  Rep Ivan Dissanayake ─────────────────────────────
(31, 'Tue-Morning'),
(31, 'Thu-Afternoon'),
(31, 'Sat-Evening'),

-- ── ID 32  Rep Julia Karunaratne ────────────────────────────
(32, 'Mon-Afternoon'),
(32, 'Wed-Evening'),
(32, 'Fri-Afternoon'),

-- ── ID 33  Rep Kevin Wijesekara ─────────────────────────────
(33, 'Tue-Evening'),
(33, 'Thu-Morning'),
(33, 'Sun-Morning'),

-- ── ID 34  Rep Laura Seneviratne ────────────────────────────
(34, 'Mon-Morning'),
(34, 'Wed-Morning'),
(34, 'Sat-Afternoon'),
(34, 'Sun-Evening'),

-- ── ID 35  Rep Mike Rajapaksa ───────────────────────────────
(35, 'Tue-Morning'),
(35, 'Fri-Evening'),
(35, 'Sat-Morning'),

-- ── ID 36  Rep Nina Samaraweera ─────────────────────────────
(36, 'Mon-Afternoon'),
(36, 'Thu-Afternoon'),
(36, 'Sun-Morning'),

-- ── ID 37  Rep Oscar Senanayake ─────────────────────────────
(37, 'Wed-Evening'),
(37, 'Fri-Morning'),
(37, 'Sat-Evening'),

-- ── ID 38  Rep Paula Wickramasinghe ─────────────────────────
(38, 'Mon-Morning'),
(38, 'Tue-Afternoon'),
(38, 'Thu-Morning'),
(38, 'Sat-Morning'),

-- ── ID 39  Rep Quinn Amarasinghe ────────────────────────────
(39, 'Wed-Morning'),
(39, 'Fri-Afternoon'),
(39, 'Sun-Evening'),

-- ── ID 40  Rep Rachel Abeywickrama ──────────────────────────
(40, 'Tue-Morning'),
(40, 'Thu-Evening'),
(40, 'Sat-Afternoon'),

-- ── ID 41  Rep Sam Tissera (suspended) ──────────────────────
(41, 'Mon-Evening'),
(41, 'Wed-Afternoon'),

-- ── ID 42  Rep Tina Herath (suspended) ──────────────────────
(42, 'Tue-Morning'),
(42, 'Sat-Evening'),

-- ── ID 43  OrgRep Uma Vithanage ─────────────────────────────
(43, 'Mon-Morning'),
(43, 'Mon-Afternoon'),
(43, 'Wed-Morning'),
(43, 'Fri-Morning'),
(43, 'Sat-Morning'),

-- ── ID 44  OrgRep Victor Nanayakkara ────────────────────────
(44, 'Tue-Morning'),
(44, 'Tue-Afternoon'),
(44, 'Thu-Morning'),
(44, 'Sat-Afternoon'),
(44, 'Sun-Morning'),

-- ── ID 45  Vol Amaya Fonseka (suspended) ────────────────────
(45, 'Sat-Morning'),
(45, 'Sun-Afternoon'),

-- ── ID 46  Vol Bimal Gunawardena (suspended) ────────────────
(46, 'Mon-Evening'),
(46, 'Fri-Morning'),

-- ── ID 47  Vol Chamari Alwis (suspended) ────────────────────
(47, 'Tue-Afternoon'),
(47, 'Sat-Evening'),

-- ── ID 48  Vol Dilan Munasinghe (suspended) ─────────────────
(48, 'Wed-Morning'),
(48, 'Sun-Morning'),

-- ── ID 49  Vol Erandi Madushani (suspended) ─────────────────
(49, 'Thu-Afternoon'),
(49, 'Sat-Morning'),

-- ── ID 50  Vol Fathima Nazeer ───────────────────────────────
(50, 'Mon-Morning'),
(50, 'Wed-Afternoon'),
(50, 'Sat-Morning'),

-- ── ID 51  Vol Gehan Kulatunga ──────────────────────────────
(51, 'Tue-Evening'),
(51, 'Thu-Morning'),
(51, 'Sun-Afternoon'),

-- ── ID 52  Vol Hiruni Dahanayake ────────────────────────────
(52, 'Mon-Morning'),
(52, 'Wed-Morning'),
(52, 'Fri-Morning'),
(52, 'Sat-Morning'),

-- ── ID 53  Vol Isuru Pathirana ──────────────────────────────
(53, 'Tue-Afternoon'),
(53, 'Sat-Evening'),

-- ── ID 54  Vol Janani Sivakumar ─────────────────────────────
(54, 'Mon-Afternoon'),
(54, 'Thu-Afternoon'),
(54, 'Sun-Morning'),

-- ── ID 55  Vol Kasun Premaratne ─────────────────────────────
(55, 'Wed-Evening'),
(55, 'Fri-Afternoon'),
(55, 'Sat-Morning'),

-- ── ID 56  Vol Lakmini Rathnayake ───────────────────────────
(56, 'Tue-Morning'),
(56, 'Sun-Evening'),

-- ── ID 57  Vol Mahesh Thisera ───────────────────────────────
(57, 'Mon-Morning'),
(57, 'Wed-Morning'),
(57, 'Fri-Evening'),
(57, 'Sat-Afternoon'),

-- ── ID 58  Vol Nadeeka Wijetunga ────────────────────────────
(58, 'Tue-Afternoon'),
(58, 'Thu-Morning'),
(58, 'Sat-Morning'),

-- ── ID 59  Vol Oshadi Jayawardena ───────────────────────────
(59, 'Mon-Evening'),
(59, 'Fri-Morning'),

-- ── ID 60  Vol Prabath Kumara ───────────────────────────────
(60, 'Wed-Afternoon'),
(60, 'Sat-Evening'),
(60, 'Sun-Morning'),

-- ── ID 61  Vol Qasim Jiffry ─────────────────────────────────
(61, 'Tue-Morning'),
(61, 'Sun-Afternoon'),

-- ── ID 62  Vol Rashmi Liyanage ──────────────────────────────
(62, 'Mon-Morning'),
(62, 'Thu-Evening'),
(62, 'Sat-Morning'),

-- ── ID 63  Vol Sachini Warnasuriya ──────────────────────────
(63, 'Tue-Afternoon'),
(63, 'Wed-Morning'),
(63, 'Fri-Afternoon'),
(63, 'Sun-Morning'),

-- ── ID 64  Vol Tharindu Samarakoon ──────────────────────────
(64, 'Mon-Afternoon'),
(64, 'Sat-Evening'),

-- ── ID 65  Vol Umayangani Peris ─────────────────────────────
(65, 'Wed-Morning'),
(65, 'Fri-Morning'),
(65, 'Sun-Afternoon'),

-- ── ID 66  Vol Vimukthi Gamage ──────────────────────────────
(66, 'Tue-Evening'),
(66, 'Sat-Morning'),

-- ── ID 67  Vol Waruni Rodrigo ───────────────────────────────
(67, 'Mon-Morning'),
(67, 'Wed-Afternoon'),
(67, 'Thu-Morning'),
(67, 'Sat-Morning'),

-- ── ID 68  Vol Xeran Marasinghe ─────────────────────────────
(68, 'Tue-Morning'),
(68, 'Sun-Evening'),

-- ── ID 69  Vol Yashodha Nandasiri ───────────────────────────
(69, 'Mon-Evening'),
(69, 'Fri-Afternoon'),
(69, 'Sat-Evening'),

-- ── ID 70  Vol Zinara Muthumala ─────────────────────────────
(70, 'Wed-Morning'),
(70, 'Thu-Afternoon'),
(70, 'Sun-Morning'),

-- ── ID 71  Vol Anura Senanayake ─────────────────────────────
(71, 'Tue-Afternoon'),
(71, 'Fri-Morning'),
(71, 'Sat-Afternoon'),

-- ── ID 72  Vol Buddhini Dharmaratne ─────────────────────────
(72, 'Mon-Morning'),
(72, 'Wed-Evening'),
(72, 'Fri-Afternoon'),
(72, 'Sat-Morning'),

-- ── ID 73  Vol Chatura Siriwardena ──────────────────────────
(73, 'Tue-Morning'),
(73, 'Sun-Morning'),

-- ── ID 74  Vol Dilani Wickrama ──────────────────────────────
(74, 'Mon-Afternoon'),
(74, 'Thu-Morning'),
(74, 'Sat-Evening'),

-- ── ID 75  Vol Eshan Kuruppu ────────────────────────────────
(75, 'Wed-Morning'),
(75, 'Fri-Evening'),
(75, 'Sat-Morning'),
(75, 'Sun-Afternoon'),

-- ── ID 76  Vol Faariya Ismail ───────────────────────────────
(76, 'Tue-Evening'),
(76, 'Sat-Morning'),

-- ── ID 77  Vol Gavesh Ekanayake ─────────────────────────────
(77, 'Mon-Morning'),
(77, 'Mon-Afternoon'),
(77, 'Wed-Morning'),
(77, 'Fri-Morning'),
(77, 'Sat-Afternoon'),

-- ── ID 78  Vol Hasitha Madanayake ───────────────────────────
(78, 'Tue-Morning'),
(78, 'Thu-Afternoon'),
(78, 'Sun-Evening'),

-- ── ID 79  Vol Imasha Senaratne ─────────────────────────────
(79, 'Mon-Evening'),
(79, 'Fri-Morning'),
(79, 'Sat-Morning'),

-- ── ID 80  Vol Jayani Koswatte ──────────────────────────────
(80, 'Wed-Afternoon'),
(80, 'Thu-Morning'),
(80, 'Sun-Morning'),

-- ── ID 81  Vol Krishan Muthukumar ───────────────────────────
(81, 'Tue-Morning'),
(81, 'Sat-Evening'),

-- ── ID 82  Vol Lakmali Chandrasekara ────────────────────────
(82, 'Mon-Morning'),
(82, 'Wed-Morning'),
(82, 'Fri-Afternoon'),
(82, 'Sat-Morning'),

-- ── ID 83  Vol Malinga Gallage ──────────────────────────────
(83, 'Tue-Afternoon'),
(83, 'Sun-Afternoon'),

-- ── ID 84  Vol Nethmi Sooriyaarachchi ───────────────────────
(84, 'Mon-Afternoon'),
(84, 'Thu-Evening'),
(84, 'Sat-Morning'),
(84, 'Sun-Morning'),

-- ── ID 85  Vol Oshan Abeyrathna ─────────────────────────────
(85, 'Wed-Morning'),
(85, 'Fri-Morning'),

-- ── ID 86  Vol Praveen Navaratnam ───────────────────────────
(86, 'Tue-Morning'),
(86, 'Thu-Afternoon'),
(86, 'Sat-Evening'),

-- ── ID 87  Vol Qudsiya Farook ───────────────────────────────
(87, 'Mon-Evening'),
(87, 'Sat-Morning'),
(87, 'Sun-Evening'),

-- ── ID 88  Vol Ravindu Amarakoon ────────────────────────────
(88, 'Mon-Morning'),
(88, 'Wed-Afternoon'),
(88, 'Fri-Morning'),
(88, 'Sat-Afternoon'),

-- ── ID 89  Vol Savini Premachandra ──────────────────────────
(89, 'Tue-Evening'),
(89, 'Thu-Morning'),
(89, 'Sun-Morning'),

-- ── ID 90  Vol Tilan Rajasekara ─────────────────────────────
(90, 'Mon-Morning'),
(90, 'Wed-Morning'),
(90, 'Sat-Morning'),

-- ── ID 91  Vol Uthpali Gunasekera ───────────────────────────
(91, 'Tue-Afternoon'),
(91, 'Fri-Evening'),

-- ── ID 92  Vol Vidusha Jayasena ─────────────────────────────
(92, 'Mon-Afternoon'),
(92, 'Thu-Afternoon'),
(92, 'Sat-Evening'),
(92, 'Sun-Morning'),

-- ── ID 93  Vol Wathsala Mendis ──────────────────────────────
(93, 'Wed-Evening'),
(93, 'Fri-Morning'),
(93, 'Sat-Morning'),

-- ── ID 94  Vol Xeniya Saman ─────────────────────────────────
(94, 'Mon-Morning'),
(94, 'Tue-Morning'),
(94, 'Thu-Morning'),
(94, 'Sat-Morning'),
(94, 'Sun-Afternoon');

INSERT INTO volunteer_disability (userid, disability) VALUES
(53, 'Mild hearing impairment'),
(61, 'Visual impairment – wears corrective lenses'),
(76, 'None declared'),
(81, 'None declared');


-- ============================================================
-- 4. VOLUNTEER BADGES
-- ============================================================

INSERT INTO volunteer_badge (userid, badgeearned, earneddate) VALUES
(52, 'Gold Volunteer',     '2024-06-01'),
(52, 'Ocean Guardian',     '2024-09-01'),
(57, 'Silver Volunteer',   '2024-05-15'),
(57, 'Forest Keeper',      '2024-08-20'),
(67, 'Community Hero',     '2024-07-10'),
(72, 'Platinum Volunteer', '2024-10-01'),
(77, 'Master Volunteer',   '2024-11-01'),
(84, 'Coral Champion',     '2024-04-22'),
(88, 'Sea Protector',      '2024-06-08'),
(94, 'Environmental Champion','2024-09-15'),
(50, 'Beach Warrior',      '2024-08-01'),
(63, 'Marine Steward',     '2024-07-22'),
(75, 'Mountain Ranger',    '2024-05-20'),
(80, 'Wetland Guardian',   '2024-10-10'),
(60, 'Mangrove Protector', '2024-09-05');


-- ============================================================
-- 5. VOLUNTEERING PROGRAMS (50 events)
--    Event types: Coral Restoration, Mountain Cleanup, City Cleanup,
--                 Mangrove Restoration, Beach Cleanup, Tree Planting
--    Organizer: manager (userid=2) or active reps (23-40)
--    States distributed: planned, active, completed, cancelled
-- ============================================================
SET @today = CURDATE();

INSERT INTO volunteering_program
  (event_id, name, description, event_type, isauthorized, state_of_event, is_annual, starpoints_reward, levelpoints_reward, event_date, time, location, gmap_link, scale, allocated_budget, max_participants, current_participants, organizer_id, createddate, duration, is_deleted)
VALUES

-- COMPLETED events (past dates)
(1,  'Hikkaduwa Coral Dive 2024',         'Restore damaged coral sections in Hikkaduwa reef.',                        'Coral Restoration',    1, 'completed', FALSE, 50, 100, DATE_SUB(@today, INTERVAL 390 DAY), '07:00:00', 'Hikkaduwa, Southern Province',         'https://maps.google.com/?q=Hikkaduwa',              'medium', 75000,  30, 28, 2,  DATE_SUB(@today, INTERVAL 399 DAY), '1 day',  FALSE),
(2,  'Ella Mountain Sweep',               'Clean hiking trails and peak areas around Ella.',                           'Mountain Cleanup',     1, 'completed', FALSE, 40, 80,  DATE_SUB(@today, INTERVAL 376 DAY), '06:00:00', 'Ella, Badulla District',               'https://maps.google.com/?q=Ella',                   'medium', 50000,  40, 38, 23, DATE_SUB(@today, INTERVAL 388 DAY), '1 day',  FALSE),
(3,  'Colombo City Green Drive',          'Collect litter and plant saplings in central Colombo.',                     'City Cleanup',         1, 'completed', FALSE, 30, 60,  DATE_SUB(@today, INTERVAL 362 DAY), '08:00:00', 'Colombo 7, Western Province',          'https://maps.google.com/?q=Colombo+7',              'large',  100000, 80, 75, 2,  DATE_SUB(@today, INTERVAL 372 DAY), '1 day',  FALSE),
(4,  'Puttalam Mangrove Restore 2024',    'Replant mangroves in eroded lagoon areas near Puttalam.',                  'Mangrove Restoration', 1, 'completed', FALSE, 50, 100, DATE_SUB(@today, INTERVAL 349 DAY), '07:00:00', 'Puttalam Lagoon, North Western Province','https://maps.google.com/?q=Puttalam+Lagoon',        'large',  120000, 60, 58, 24, DATE_SUB(@today, INTERVAL 362 DAY), '1 day',  FALSE),
(5,  'Negombo Beach Cleanup April',       'Remove plastic waste along Negombo beach stretch.',                        'Beach Cleanup',        1, 'completed', FALSE, 35, 70,  DATE_SUB(@today, INTERVAL 339 DAY), '06:30:00', 'Negombo Beach, Western Province',      'https://maps.google.com/?q=Negombo+Beach',          'medium', 40000,  50, 47, 25, DATE_SUB(@today, INTERVAL 352 DAY), '1 day',  FALSE),
(6,  'Sinharaja Tree Planting Drive',     'Plant endemic tree species at the Sinharaja buffer zone.',                 'Tree Planting',        1, 'completed', TRUE,  45, 90,  DATE_SUB(@today, INTERVAL 325 DAY), '07:00:00', 'Sinharaja Forest Reserve, Sabaragamuwa','https://maps.google.com/?q=Sinharaja',              'large',  90000,  70, 66, 2,  DATE_SUB(@today, INTERVAL 339 DAY), '1 day',  FALSE),
(7,  'Unawatuna Coral Survey & Restore',  'Survey reef health and restore coral fragments off Unawatuna.',            'Coral Restoration',    1, 'completed', FALSE, 50, 100, DATE_SUB(@today, INTERVAL 312 DAY), '07:00:00', 'Unawatuna Bay, Southern Province',     'https://maps.google.com/?q=Unawatuna',              'small',  55000,  20, 20, 26, DATE_SUB(@today, INTERVAL 327 DAY), '1 day',  FALSE),
(8,  'Knuckles Mountain Trail Clean',     'Remove waste from Knuckles Range hiking trails.',                          'Mountain Cleanup',     1, 'completed', FALSE, 40, 80,  DATE_SUB(@today, INTERVAL 298 DAY), '06:00:00', 'Knuckles Range, Central Province',     'https://maps.google.com/?q=Knuckles+Range',         'medium', 60000,  35, 33, 27, DATE_SUB(@today, INTERVAL 312 DAY), '1 day',  FALSE),
(9,  'Gampaha City Cleanup',              'Reduce littering in Gampaha town centre and parks.',                       'City Cleanup',         1, 'completed', FALSE, 30, 60,  DATE_SUB(@today, INTERVAL 284 DAY), '08:00:00', 'Gampaha Town, Western Province',       'https://maps.google.com/?q=Gampaha',                'medium', 45000,  50, 48, 2,  DATE_SUB(@today, INTERVAL 298 DAY), '1 day',  FALSE),
(10, 'Chilaw Mangrove Restoration',       'Replant mangroves along Chilaw Lagoon coastline.',                         'Mangrove Restoration', 1, 'completed', FALSE, 50, 100, DATE_SUB(@today, INTERVAL 270 DAY), '07:00:00', 'Chilaw Lagoon, North Western Province','https://maps.google.com/?q=Chilaw+Lagoon',          'medium', 80000,  45, 43, 28, DATE_SUB(@today, INTERVAL 284 DAY), '1 day',  FALSE),
(11, 'Mirissa Beach Cleanup',             'Collect marine debris and plastic along Mirissa beach.',                   'Beach Cleanup',        1, 'completed', FALSE, 35, 70,  DATE_SUB(@today, INTERVAL 256 DAY), '06:30:00', 'Mirissa Beach, Southern Province',     'https://maps.google.com/?q=Mirissa+Beach',          'medium', 42000,  40, 39, 29, DATE_SUB(@today, INTERVAL 270 DAY), '1 day',  FALSE),
(12, 'Victoria Park Tree Planting',       'Plant shade trees and ornamental plants in Victoria Park, Colombo.',       'Tree Planting',        1, 'completed', FALSE, 45, 90,  DATE_SUB(@today, INTERVAL 242 DAY), '07:30:00', 'Victoria Park, Colombo 7',             'https://maps.google.com/?q=Victoria+Park+Colombo', 'small',  35000,  25, 24, 2,  DATE_SUB(@today, INTERVAL 256 DAY), '1 day',  FALSE),
(13, 'Weligama Coral Restoration',        'Restore coral gardens destroyed by warming events near Weligama.',         'Coral Restoration',    1, 'completed', FALSE, 50, 100, DATE_SUB(@today, INTERVAL 228 DAY), '07:00:00', 'Weligama Bay, Southern Province',      'https://maps.google.com/?q=Weligama+Bay',           'medium', 70000,  30, 29, 30, DATE_SUB(@today, INTERVAL 242 DAY), '1 day',  FALSE),
(14, 'Horton Plains Cleanup',             'Remove litter from World End trail and surrounding plains.',               'Mountain Cleanup',     1, 'completed', TRUE,  40, 80,  DATE_SUB(@today, INTERVAL 213 DAY), '05:30:00', 'Horton Plains, Nuwara Eliya',          'https://maps.google.com/?q=Horton+Plains',          'medium', 65000,  40, 37, 31, DATE_SUB(@today, INTERVAL 228 DAY), '1 day',  FALSE),
(15, 'Dehiwala City Cleanup',             'Clean streets and drains in Dehiwala-Mount Lavinia area.',                 'City Cleanup',         1, 'completed', FALSE, 30, 60,  DATE_SUB(@today, INTERVAL 200 DAY), '08:00:00', 'Dehiwala, Western Province',           'https://maps.google.com/?q=Dehiwala',               'large',  50000,  60, 57, 2,  DATE_SUB(@today, INTERVAL 213 DAY), '1 day',  FALSE),
(16, 'Mannar Mangrove Restoration',       'Rehabilitate mangrove ecosystems on the Mannar island coast.',             'Mangrove Restoration', 1, 'completed', FALSE, 50, 100, DATE_SUB(@today, INTERVAL 186 DAY), '07:00:00', 'Mannar Island, Northern Province',     'https://maps.google.com/?q=Mannar+Island',          'large',  110000, 55, 52, 32, DATE_SUB(@today, INTERVAL 200 DAY), '1 day',  FALSE),
(17, 'Arugam Bay Beach Cleanup',          'Post-season cleanup of Arugam Bay surf beach.',                            'Beach Cleanup',        1, 'completed', FALSE, 35, 70,  DATE_SUB(@today, INTERVAL 172 DAY), '06:30:00', 'Arugam Bay, Eastern Province',         'https://maps.google.com/?q=Arugam+Bay',             'medium', 48000,  45, 44, 33, DATE_SUB(@today, INTERVAL 186 DAY), '1 day',  FALSE),
(18, 'Kandy Periurban Tree Planting',     'Plant trees along Kandy periurban roads and temple grounds.',              'Tree Planting',        1, 'completed', FALSE, 45, 90,  DATE_SUB(@today, INTERVAL 158 DAY), '07:00:00', 'Kandy, Central Province',              'https://maps.google.com/?q=Kandy',                  'large',  95000,  65, 63, 2,  DATE_SUB(@today, INTERVAL 172 DAY), '1 day',  FALSE),
(19, 'Pasikudah Coral Restoration',       'Coral fragment nursery seeding at Pasikudah lagoon.',                      'Coral Restoration',    1, 'completed', FALSE, 50, 100, DATE_SUB(@today, INTERVAL 144 DAY), '07:00:00', 'Pasikudah, Eastern Province',          'https://maps.google.com/?q=Pasikudah',              'medium', 72000,  28, 27, 34, DATE_SUB(@today, INTERVAL 158 DAY), '1 day',  FALSE),
(20, 'Adam\'s Peak Trail Cleanup',        'Remove waste from the sacred Adam\'s Peak pilgrimage trail.',              'Mountain Cleanup',     1, 'completed', TRUE,  40, 80,  DATE_SUB(@today, INTERVAL 130 DAY), '04:00:00', 'Adam\'s Peak, Sabaragamuwa',           'https://maps.google.com/?q=Adams+Peak',             'large',  85000,  50, 48, 35, DATE_SUB(@today, INTERVAL 144 DAY), '1 day',  FALSE),

-- CANCELLED events
(21, 'Trincomalee Beach Cleanup Nov',     'Cancelled due to cyclone warning.',                                        'Beach Cleanup',        1, 'cancelled', FALSE, 35, 70,  DATE_SUB(@today, INTERVAL 120 DAY), '06:30:00', 'Trincomalee Beach, Eastern Province',  'https://maps.google.com/?q=Trincomalee+Beach',      'medium', 40000,  40, 10, 2,  DATE_SUB(@today, INTERVAL 130 DAY), '1 day',  FALSE),
(22, 'Jaffna City Cleanup Dec',           'Cancelled – organiser unavailability.',                                    'City Cleanup',         0, 'cancelled', FALSE, 30, 60,  DATE_SUB(@today, INTERVAL 110 DAY), '08:00:00', 'Jaffna, Northern Province',            'https://maps.google.com/?q=Jaffna',                 'medium', 45000,  55, 5,  36, DATE_SUB(@today, INTERVAL 120 DAY), '1 day',  FALSE),

-- ACTIVE events (today)
(23, 'Colombo Grand City Cleanup Apr 26', 'Large-scale Colombo city cleanup for Earth Month.',                        'City Cleanup',         1, 'active',    FALSE, 35, 70,  @today,                              '08:00:00', 'Colombo Fort, Western Province',       'https://maps.google.com/?q=Colombo+Fort',           'large',  120000, 100,87, 2,  DATE_SUB(@today, INTERVAL 30 DAY),  '1 day',  FALSE),
(24, 'Negombo Mangrove Weekend',          'Two-day mangrove replanting drive on the Negombo lagoon.',                 'Mangrove Restoration', 1, 'active',    FALSE, 55, 110, @today,                              '07:00:00', 'Negombo Lagoon, Western Province',     'https://maps.google.com/?q=Negombo+Lagoon',         'large',  130000, 70, 62, 37, DATE_SUB(@today, INTERVAL 30 DAY),  '2 days', FALSE),
(25, 'Hikkaduwa April Coral Dive',        'Monthly coral restoration dive in Hikkaduwa reef.',                        'Coral Restoration',    1, 'active',    FALSE, 50, 100, @today,                              '07:00:00', 'Hikkaduwa Reef, Southern Province',    'https://maps.google.com/?q=Hikkaduwa+Reef',         'medium', 75000,  25, 22, 38, DATE_SUB(@today, INTERVAL 30 DAY),  '1 day',  FALSE),

-- PLANNED events (future dates)
(26, 'Galle Beach Spring Cleanup',        'Pre-season beach cleanup for the southern coast.',                         'Beach Cleanup',        1, 'planned',   FALSE, 35, 70,  DATE_ADD(@today, INTERVAL 13 DAY),  '06:30:00', 'Galle Face Beach, Southern Province',  'https://maps.google.com/?q=Galle+Face',             'medium', 50000,  50, 12, 2,  DATE_SUB(@today, INTERVAL 10 DAY),  '1 day',  FALSE),
(27, 'Matale Tree Planting Festival',     'Community tree planting in Matale District schools.',                      'Tree Planting',        1, 'planned',   TRUE,  45, 90,  DATE_ADD(@today, INTERVAL 18 DAY),  '07:00:00', 'Matale, Central Province',             'https://maps.google.com/?q=Matale',                 'large',  100000, 80, 20, 39, DATE_SUB(@today, INTERVAL 10 DAY),  '1 day',  FALSE),
(28, 'Hambantota Beach Cleanup',          'Clean plastic waste at Hambantota port beach area.',                       'Beach Cleanup',        1, 'planned',   FALSE, 35, 70,  DATE_ADD(@today, INTERVAL 25 DAY),  '06:30:00', 'Hambantota Beach, Southern Province',  'https://maps.google.com/?q=Hambantota+Beach',       'medium', 45000,  45, 8,  40, DATE_SUB(@today, INTERVAL 10 DAY),  '1 day',  FALSE),
(29, 'Colombo Botanical Garden Trees',    'Tree planting at Peradeniya Botanical satellite garden Colombo.',          'Tree Planting',        1, 'planned',   FALSE, 45, 90,  DATE_ADD(@today, INTERVAL 31 DAY),  '07:30:00', 'Colombo 5, Western Province',          'https://maps.google.com/?q=Colombo+5',              'small',  35000,  25, 5,  2,  DATE_SUB(@today, INTERVAL 10 DAY),  '1 day',  FALSE),
(30, 'Knuckles Eco Cleanup May',          'Monthly mountain cleanup on Knuckles Range eastern trails.',               'Mountain Cleanup',     1, 'planned',   FALSE, 40, 80,  DATE_ADD(@today, INTERVAL 38 DAY),  '06:00:00', 'Knuckles Range, Central Province',     'https://maps.google.com/?q=Knuckles',               'medium', 60000,  40, 7,  23, DATE_SUB(@today, INTERVAL 10 DAY),  '1 day',  FALSE),
(31, 'Kalpitiya Mangrove Restoration',    'Mangrove ecosystem rehabilitation in the Kalpitiya peninsula.',            'Mangrove Restoration', 1, 'planned',   TRUE,  55, 110, DATE_ADD(@today, INTERVAL 45 DAY),  '07:00:00', 'Kalpitiya, North Western Province',    'https://maps.google.com/?q=Kalpitiya',              'large',  140000, 65, 10, 24, DATE_SUB(@today, INTERVAL 10 DAY),  '2 days', FALSE),
(32, 'Trincomalee Coral Restoration',     'Coral nursery seeding and transplantation at Trincomalee bay.',            'Coral Restoration',    1, 'planned',   FALSE, 50, 100, DATE_ADD(@today, INTERVAL 52 DAY),  '07:00:00', 'Trincomalee Bay, Eastern Province',    'https://maps.google.com/?q=Trincomalee+Bay',        'medium', 78000,  30, 4,  25, DATE_SUB(@today, INTERVAL 10 DAY),  '1 day',  FALSE),
(33, 'Kurunegala City Cleanup',           'City-wide cleanup campaign in Kurunegala.',                                'City Cleanup',         1, 'planned',   FALSE, 30, 60,  DATE_ADD(@today, INTERVAL 59 DAY),  '08:00:00', 'Kurunegala, North Western Province',   'https://maps.google.com/?q=Kurunegala',             'medium', 47000,  55, 6,  2,  DATE_SUB(@today, INTERVAL 10 DAY),  '1 day',  FALSE),
(34, 'Batticaloa Beach Cleanup',          'Coastal cleanup on Batticaloa lagoon beach.',                              'Beach Cleanup',        1, 'planned',   FALSE, 35, 70,  DATE_ADD(@today, INTERVAL 66 DAY),  '06:30:00', 'Batticaloa Beach, Eastern Province',   'https://maps.google.com/?q=Batticaloa+Beach',       'medium', 43000,  40, 3,  26, DATE_SUB(@today, INTERVAL 10 DAY),  '1 day',  FALSE),
(35, 'Nuwara Eliya Mountain Cleanup',     'Clean trails around Nuwara Eliya highlands.',                              'Mountain Cleanup',     1, 'planned',   FALSE, 40, 80,  DATE_ADD(@today, INTERVAL 73 DAY),  '06:00:00', 'Nuwara Eliya, Central Province',       'https://maps.google.com/?q=Nuwara+Eliya',           'medium', 58000,  38, 5,  27, DATE_SUB(@today, INTERVAL 10 DAY),  '1 day',  FALSE),
(36, 'Ampara Mangrove Planting',          'Restore mangroves lost to coastal erosion near Ampara.',                   'Mangrove Restoration', 1, 'planned',   FALSE, 50, 100, DATE_ADD(@today, INTERVAL 80 DAY),  '07:00:00', 'Ampara, Eastern Province',             'https://maps.google.com/?q=Ampara',                 'medium', 82000,  50, 4,  28, DATE_SUB(@today, INTERVAL 10 DAY),  '1 day',  FALSE),
(37, 'Matara City Green Challenge',       'Matara citywide anti-litter and green corridor project.',                  'City Cleanup',         1, 'planned',   FALSE, 30, 60,  DATE_ADD(@today, INTERVAL 87 DAY),  '08:00:00', 'Matara, Southern Province',            'https://maps.google.com/?q=Matara',                 'large',  55000,  70, 9,  2,  DATE_SUB(@today, INTERVAL 10 DAY),  '1 day',  FALSE),
(38, 'Peradeniya Tree Planting',          'Native tree planting within Peradeniya University campus.',                'Tree Planting',        1, 'planned',   FALSE, 45, 90,  DATE_ADD(@today, INTERVAL 94 DAY),  '07:00:00', 'Peradeniya, Central Province',         'https://maps.google.com/?q=Peradeniya',             'medium', 68000,  60, 7,  29, DATE_SUB(@today, INTERVAL 10 DAY),  '1 day',  FALSE),
(39, 'Dikwella Coral Survey',             'Underwater survey and restoration at Dikwella reef.',                      'Coral Restoration',    1, 'planned',   FALSE, 50, 100, DATE_ADD(@today, INTERVAL 101 DAY), '07:00:00', 'Dikwella, Southern Province',          'https://maps.google.com/?q=Dikwella',               'small',  60000,  20, 2,  30, DATE_SUB(@today, INTERVAL 10 DAY),  '1 day',  FALSE),
(40, 'Weligama Beach Cleanup',            'Mid-year beach cleanup at Weligama bay.',                                  'Beach Cleanup',        1, 'planned',   FALSE, 35, 70,  DATE_ADD(@today, INTERVAL 108 DAY), '06:30:00', 'Weligama Beach, Southern Province',    'https://maps.google.com/?q=Weligama+Beach',         'medium', 46000,  45, 4,  31, DATE_SUB(@today, INTERVAL 10 DAY),  '1 day',  FALSE),
(41, 'Udawalawe Tree Planting',           'Tree planting in the buffer zone of Udawalawe National Park.',             'Tree Planting',        1, 'planned',   TRUE,  45, 90,  DATE_ADD(@today, INTERVAL 115 DAY), '07:00:00', 'Udawalawe, Sabaragamuwa',              'https://maps.google.com/?q=Udawalawe',              'large',  105000, 75, 6,  2,  DATE_SUB(@today, INTERVAL 10 DAY),  '1 day',  FALSE),
(42, 'Dondra Coral Restoration',          'Southernmost reef restoration project at Dondra Head.',                    'Coral Restoration',    1, 'planned',   FALSE, 50, 100, DATE_ADD(@today, INTERVAL 122 DAY), '07:00:00', 'Dondra, Southern Province',            'https://maps.google.com/?q=Dondra',                 'medium', 74000,  28, 3,  32, DATE_SUB(@today, INTERVAL 10 DAY),  '1 day',  FALSE),
(43, 'Ratnapura City Cleanup',            'Gem city cleanup and awareness drive.',                                    'City Cleanup',         1, 'planned',   FALSE, 30, 60,  DATE_ADD(@today, INTERVAL 129 DAY), '08:00:00', 'Ratnapura, Sabaragamuwa',              'https://maps.google.com/?q=Ratnapura',              'medium', 48000,  55, 5,  33, DATE_SUB(@today, INTERVAL 10 DAY),  '1 day',  FALSE),
(44, 'Bundala Mangrove Restoration',      'Restore mangrove patches adjacent to Bundala wetland reserve.',            'Mangrove Restoration', 1, 'planned',   TRUE,  55, 110, DATE_ADD(@today, INTERVAL 136 DAY), '07:00:00', 'Bundala, Southern Province',           'https://maps.google.com/?q=Bundala',                'large',  125000, 60, 4,  34, DATE_SUB(@today, INTERVAL 10 DAY),  '1 day',  FALSE),
(45, 'Pidurutalagala Mountain Cleanup',   'High-altitude cleanup on Sri Lanka\'s tallest mountain.',                  'Mountain Cleanup',     1, 'planned',   FALSE, 45, 90,  DATE_ADD(@today, INTERVAL 143 DAY), '05:00:00', 'Pidurutalagala, Nuwara Eliya',         'https://maps.google.com/?q=Pidurutalagala',         'small',  55000,  20, 2,  35, DATE_SUB(@today, INTERVAL 10 DAY),  '1 day',  FALSE),
(46, 'Kinniya Beach Cleanup',             'Post-monsoon beach cleanup on Kinniya coast.',                             'Beach Cleanup',        1, 'planned',   FALSE, 35, 70,  DATE_ADD(@today, INTERVAL 150 DAY), '06:30:00', 'Kinniya, Eastern Province',            'https://maps.google.com/?q=Kinniya',                'medium', 44000,  40, 3,  2,  DATE_SUB(@today, INTERVAL 10 DAY),  '1 day',  FALSE),
(47, 'Colombo Annual Tree Planting',      'Annual mass tree planting across all Colombo districts.',                  'Tree Planting',        1, 'planned',   TRUE,  50, 100, DATE_ADD(@today, INTERVAL 157 DAY), '07:00:00', 'Multiple Colombo Districts',           'https://maps.google.com/?q=Colombo',                'large',  150000, 120,15, 2,  DATE_SUB(@today, INTERVAL 10 DAY),  '1 day',  FALSE),
(48, 'Mullaitivu Mangrove Restoration',   'Northern coast mangrove restoration in post-conflict areas.',              'Mangrove Restoration', 1, 'planned',   FALSE, 55, 110, DATE_ADD(@today, INTERVAL 164 DAY), '07:00:00', 'Mullaitivu, Northern Province',        'https://maps.google.com/?q=Mullaitivu',             'large',  135000, 65, 5,  36, DATE_SUB(@today, INTERVAL 10 DAY),  '2 days', FALSE),
(49, 'Bentota Coral Dive',                'Coral fragment transplantation at Bentota reef.',                          'Coral Restoration',    1, 'planned',   FALSE, 50, 100, DATE_ADD(@today, INTERVAL 171 DAY), '07:00:00', 'Bentota Reef, Southern Province',      'https://maps.google.com/?q=Bentota+Reef',           'medium', 71000,  25, 2,  37, DATE_SUB(@today, INTERVAL 10 DAY),  '1 day',  FALSE),
(50, 'Jaffna Northern Beach Cleanup',     'Year-end northern coast beach cleanup and awareness drive.',               'Beach Cleanup',        1, 'planned',   FALSE, 35, 70,  DATE_ADD(@today, INTERVAL 185 DAY), '06:30:00', 'Jaffna, Northern Province',            'https://maps.google.com/?q=Jaffna+Beach',           'large',  90000,  70, 3,  2,  DATE_SUB(@today, INTERVAL 10 DAY),  '1 day',  FALSE);
-- ============================================================
-- 6. EVENT PARTICIPATION (sample — active volunteers in completed/active events)
-- ============================================================

INSERT INTO event_participation (event_id, volunteer_id, participation_status) VALUES
-- Event 1 (Coral Restoration - completed)
(1, 50, 'completed'), (1, 52, 'completed'), (1, 55, 'completed'),
(1, 63, 'completed'), (1, 66, 'completed'), (1, 74, 'completed'),
(1, 84, 'completed'), (1, 93, 'completed'),
-- Event 2 (Mountain Cleanup - completed)
(2, 54, 'completed'), (2, 57, 'completed'), (2, 64, 'completed'),
(2, 67, 'completed'), (2, 72, 'completed'), (2, 75, 'completed'),
(2, 88, 'completed'),
-- Event 3 (City Cleanup - completed)
(3, 50, 'completed'), (3, 51, 'completed'), (3, 59, 'completed'),
(3, 62, 'completed'), (3, 65, 'completed'), (3, 71, 'completed'),
(3, 78, 'completed'), (3, 82, 'completed'), (3, 90, 'completed'),
-- Event 5 (Beach Cleanup - completed)
(5, 58, 'completed'), (5, 69, 'completed'), (5, 79, 'completed'),
(5, 87, 'completed'), (5, 94, 'completed'),
-- Event 6 (Tree Planting - completed, annual)
(6, 50, 'completed'), (6, 56, 'completed'), (6, 65, 'completed'),
(6, 73, 'completed'), (6, 77, 'completed'), (6, 83, 'completed'),
(6, 91, 'completed'),
-- Event 23 (Active - City Cleanup)
(23, 52, 'registered'), (23, 57, 'registered'), (23, 60, 'registered'),
(23, 67, 'registered'), (23, 72, 'registered'), (23, 77, 'registered'),
(23, 82, 'registered'), (23, 86, 'registered'), (23, 88, 'registered'),
(23, 90, 'attended'),   (23, 92, 'attended'),   (23, 94, 'attended'),
-- Event 24 (Active - Mangrove)
(24, 51, 'attended'), (24, 60, 'attended'), (24, 70, 'attended'),
(24, 80, 'attended'), (24, 89, 'attended'),
-- Event 25 (Active - Coral)
(25, 50, 'attended'), (25, 55, 'attended'), (25, 63, 'attended'),
(25, 74, 'attended'), (25, 84, 'attended');


-- ============================================================
-- 7. TASKS
-- ============================================================

INSERT INTO task (task_id, name, description, status, event_id, max_participants, current_participants, organizer_id) VALUES
(1,  'Coral Fragment Collection',   'Collect healthy coral fragments for nursery.',        'completed',  1,  10, 8,  2),
(2,  'Reef Photography',            'Document reef condition before and after.',            'completed',  1,  5,  5,  2),
(3,  'Trail Litter Collection',     'Walk trails and collect all litter into bags.',        'completed',  2,  15, 14, 23),
(4,  'Sorting & Recycling',         'Sort collected waste into recyclable categories.',     'completed',  2,  10, 10, 23),
(5,  'Street Sweeping',             'Sweep main streets in assigned grid zone.',            'completed',  3,  25, 23, 2),
(6,  'Drain Clearance',             'Clear blocked drains of plastic and leaf waste.',      'completed',  3,  15, 14, 2),
(7,  'Sapling Planting',            'Plant mangrove saplings in pre-dug holes.',            'completed',  4,  20, 19, 24),
(8,  'Rope Net Setup',              'Set up protective rope nets for young saplings.',      'completed',  4,  10, 9,  24),
(9,  'Beach Zone Sweep',            'Sweep and bag litter on assigned beach zone.',         'completed',  5,  15, 14, 25),
(10, 'Data Recording',              'Record GPS locations of waste hotspots.',              'completed',  5,  5,  5,  25),
(11, 'Coral Monitoring',            'Monitor coral fragment growth in nursery.',            'inprogress', 23, 8,  5,  2),
(12, 'City Zone A Cleanup',         'Assigned streets zone A – Colombo Fort.',             'inprogress', 23, 30, 28, 2),
(13, 'Mangrove Planting Team',      'Plant saplings along assigned lagoon section.',        'inprogress', 24, 20, 18, 37),
(14, 'Root Protection',             'Install bamboo stakes for sapling root protection.',   'pending',    24, 10, 3,  37),
(15, 'Coral Survey Transect',       'Swim 100m transect and record coral health.',         'inprogress', 25, 8,  6,  38);


-- ============================================================
-- 8. TASK ASSIGNMENTS
-- ============================================================

INSERT INTO task_assignment (task_id, volunteer_id) VALUES
(1, 50), (1, 55), (1, 63), (1, 74), (1, 84),
(2, 52), (2, 66), (2, 93),
(3, 54), (3, 57), (3, 64), (3, 67), (3, 72), (3, 75), (3, 88),
(4, 54), (4, 57), (4, 64), (4, 67),
(5, 50), (5, 59), (5, 62), (5, 65), (5, 71), (5, 78), (5, 82),
(6, 51), (6, 62), (6, 71), (6, 82), (6, 90),
(7, 51), (7, 60), (7, 70), (7, 80), (7, 89),
(8, 60), (8, 70), (8, 80),
(9, 58), (9, 69), (9, 79), (9, 87), (9, 94),
(10, 52), (10, 57),
(11, 50), (11, 55), (11, 63),
(12, 52), (12, 57), (12, 67), (12, 72), (12, 77), (12, 82), (12, 88), (12, 90), (12, 92),
(13, 51), (13, 60), (13, 70), (13, 80), (13, 89),
(14, 60), (14, 70), (14, 89),
(15, 50), (15, 55), (15, 63), (15, 74), (15, 84);


-- ============================================================
-- 9. RATINGS
-- ============================================================

-- Peer Ratings (completed events)
INSERT INTO peer_rating (peer_rating_score, comment, rater_id, ratee_id, event_id) VALUES
(4.5, 'Great teamwork on the reef.',        50, 55, 1),
(4.0, 'Very cooperative volunteer.',        55, 50, 1),
(4.8, 'Excellent photography work.',        50, 52, 1),
(3.9, 'Good effort on trail cleanup.',      54, 57, 2),
(4.6, 'Outstanding leadership.',            57, 67, 2),
(4.2, 'Efficient in sorting waste.',        67, 72, 2),
(4.7, 'Kept the team motivated.',           52, 57, 3),
(4.1, 'Hardworking throughout the day.',    57, 50, 3),
(4.3, 'Expert in coral restoration.',       55, 63, 1),
(4.9, 'Exceptional volunteer.',             63, 84, 1);

-- Task Performance Ratings
INSERT INTO task_performance_rating (task_id, volunteer_id, rater_id, performance_score, comment) VALUES
(1,  50, 2,  4.5, 'Excellent coral fragment handling.'),
(1,  55, 2,  4.3, 'Good technique and care.'),
(1,  63, 2,  4.6, 'Thorough and efficient.'),
(2,  52, 2,  4.8, 'Professional underwater photography.'),
(3,  57, 23, 4.7, 'Trail fully cleared ahead of schedule.'),
(3,  67, 23, 4.4, 'Strong contribution throughout.'),
(5,  50, 2,  4.2, 'Covered full assigned zone.'),
(5,  82, 2,  4.0, 'Consistent effort.'),
(7,  60, 24, 4.6, 'Expert mangrove planting technique.'),
(9,  58, 25, 4.3, 'Careful and systematic beach sweep.');

-- Attendance Ratings
INSERT INTO attendance_rating (event_id, volunteer_id, rater_id, attendance_score) VALUES
(1, 50, 2,  5.0),
(1, 52, 2,  5.0),
(1, 55, 2,  5.0),
(1, 63, 2,  5.0),
(1, 66, 2,  4.5),
(2, 54, 23, 5.0),
(2, 57, 23, 5.0),
(2, 67, 23, 5.0),
(3, 50, 2,  5.0),
(3, 59, 2,  4.5),
(3, 82, 2,  5.0),
(5, 58, 25, 5.0),
(5, 94, 25, 5.0),
(6, 56, 2,  5.0),
(6, 77, 2,  5.0);


-- ============================================================
-- 10. DONATIONS
-- ============================================================

INSERT INTO donation (donationid, receivedamount, sponsorid, volunteer_id, event_id, order_id, transaction_id, transaction_date, status) VALUES
(1,  500000.00, 3,  NULL, 6,  'ORD-20240512-001', 'TXN-001', '2024-05-10 10:00:00', 'pending'),
(2,  250000.00, 4,  NULL, 6,  'ORD-20240512-002', 'TXN-002', '2024-05-11 09:30:00', 'pending'),
(3,  150000.00, 5,  NULL, 3,  'ORD-20240405-001', 'TXN-003', '2024-04-03 14:00:00', 'pending'),
(4,  300000.00, 6,  NULL, 16, 'ORD-20240928-001', 'TXN-004', '2024-09-26 11:00:00', 'pending'),
(5,  100000.00, 7,  NULL, 18, 'ORD-20241026-001', 'TXN-005', '2024-10-24 08:45:00', 'pending'),
(6,  75000.00,  NULL, 52, 5,  'ORD-20240428-001', 'TXN-006', '2024-04-25 16:00:00', 'pending'),
(7,  50000.00,  NULL, 77, 2,  'ORD-20240322-001', 'TXN-007', '2024-03-20 12:30:00', 'pending'),
(8,  200000.00, 8,  NULL, 23, 'ORD-20260401-001', 'TXN-008', '2026-03-30 10:00:00', 'pending'),
(9,  180000.00, 9,  NULL, 24, 'ORD-20260401-002', 'TXN-009', '2026-03-31 09:00:00', 'pending'),
(10, 120000.00, 10, NULL, 25, 'ORD-20260401-003', 'TXN-010', '2026-04-01 08:00:00', 'pending');


-- ============================================================
-- 11. ITEMS (Merchandise — post-alteration schema)
-- ============================================================

INSERT INTO item (itemid, itemtype, emoji, description, price, stock_XS, stock_S, stock_M, stock_L, stock_XL, stock_XXL, is_active, managinguserid) VALUES
(1, 'T-Shirt',     '👕', 'V Volunteer branded T-shirt.',       1500.00, 10, 20, 25, 20, 10, 5,  1, 2),
(2, 'Cap',         '🧢', 'V embroidered volunteer cap.',        800.00,  0,  0,  50, 0,  0,  0,  1, 2),
(3, 'Water Bottle','💧', 'Eco-friendly reusable water bottle.', 1200.00, 0,  0,  40, 0,  0,  0,  1, 2),
(4, 'Tote Bag',    '🛍️', 'Recycled canvas tote bag.',          600.00,  0,  0,  60, 0,  0,  0,  1, 2),
(5, 'Hoodie',      '🧥', 'V Volunteer hoodie – limited edition.',3500.00,5, 10, 15, 10, 8,  3,  1, 2);


-- ============================================================
-- 12. ANNOUNCEMENTS
-- ============================================================

INSERT INTO announcement (title, message, event_id, is_urgent) VALUES
('April City Cleanup – Volunteers Needed!',  'Join us on April 2nd for the Colombo Grand City Cleanup. All active volunteers are encouraged to register.', 23, TRUE),
('Hikkaduwa Coral Dive This Weekend',        'Reminder: Coral dive event on April 2nd. Bring your diving gear and report by 7 AM.',                         25, FALSE),
('Negombo Mangrove Drive Underway',          'The Negombo mangrove restoration event has started. Extra hands welcome at the lagoon site.',                  24, FALSE),
('Upcoming Tree Planting – Matale',          'Register now for the Matale Tree Planting Festival on April 20th. Limited slots remaining.',                   27, FALSE),
('System Maintenance Notice',                'The V platform will undergo scheduled maintenance on April 5th from 2–4 AM. Save your work beforehand.',       NULL, TRUE);


-- ============================================================
-- 13. REQUESTS
-- ============================================================

INSERT INTO request (request_id, description, status, requester_volunteer_id, handler_representative_id, approver_manager_id, type, linkedin) VALUES
(1, 'I would like to become a representative for the Southern region.',             'approved',  52, 30, 2, 'applytoberep',        'https://linkedin.com/in/vol52'),
(2, 'Request to apply for representative role in Western Province.',                'pending',   57, NULL, NULL, 'applytoberep',   'https://linkedin.com/in/vol57'),
(3, 'Application to represent Northern district volunteering efforts.',             'rejected',  72, 31, 2, 'applytoberep',        'https://linkedin.com/in/vol72'),
(4, 'Requesting sponsorship for Beach Cleanup April 2026 event.',                  'approved',  NULL, NULL, 2, 'requestforsponsorship', NULL),
(5, 'Volunteer sponsor relationship request for event 27.',                         'pending',   NULL, NULL, NULL, 'requesttosponsor', NULL);

-- Sponsorship Requests
INSERT INTO sponsorship_request (request_id, event_id, sponsorid) VALUES
(4, 26, 3),
(5, 27, 5);


-- ============================================================
-- 14. PEER RATING ASSIGNMENTS (for active events)
-- ============================================================

INSERT INTO peer_rating_assignment (event_id, rater_id, ratee_id, status) VALUES
(23, 52, 57, 'pending'), (23, 57, 52, 'pending'),
(23, 67, 72, 'pending'), (23, 72, 67, 'pending'),
(23, 77, 88, 'pending'), (23, 88, 77, 'pending'),
(24, 51, 60, 'pending'), (24, 60, 51, 'pending'),
(24, 70, 80, 'pending'), (24, 80, 70, 'pending'),
(25, 50, 55, 'pending'), (25, 55, 50, 'pending'),
(25, 63, 74, 'pending'), (25, 74, 63, 'pending');


-- ============================================================
-- 15. VOLUNTEER LEAVE HISTORY
-- ============================================================

INSERT INTO volunteer_leave_history (volunteer_id, event_id, days_before_event, level_points_lost, star_points_lost, reason) VALUES
(45, 3,  2, 20, 5, 'Personal emergency.'),
(46, 5,  1, 30, 8, 'Illness.'),
(48, 6,  3, 10, 2, 'Family commitment.'),
(49, 2,  0, 40, 10, 'No-show – no reason given.'),
(47, 1,  5, 0,  0, 'Withdrew early – above 5-day threshold, no penalty.');


-- ============================================================
-- 16. SPONSOR EVENT COMMITMENTS
-- ============================================================
INSERT INTO sponsor_event_commitment 
(commitment_id, sponsor_id, event_id, commitment_date, commitment_amount, status) 
VALUES
(3,  6,  1, '2026-04-01', 500000.00, 'accepted'),
(4,  6,  2, '2026-04-01', 250000.00, 'accepted'),
(5,  3,  3, '2026-04-01', 150000.00, 'accepted'),
(6,  16, 4, '2026-04-01', 300000.00, 'accepted'),
(7,  18, 5, '2026-04-01', 100000.00, 'accepted'),
(8,  23, 6, '2026-04-01', 200000.00, 'accepted'),
(9,  24, 7, '2026-04-01', 180000.00, 'accepted'),
(10, 25, 8, '2026-04-01', 120000.00, 'accepted'),
(11, 26, 9, '2026-04-01', 80000.00, 'not accepted'),
(12, 27, 10,'2026-04-01', 150000.00, 'not accepted');


-- ============================================================
-- 17. EVENT BUDGET ITEMS
-- ============================================================

INSERT INTO event_budget_item (event_id, item_name, item_price) VALUES
(23, 'Garbage bags (bulk)',       5000.00),
(23, 'Safety gloves',            12000.00),
(23, 'Volunteer T-shirts',       35000.00),
(23, 'Refreshments',             20000.00),
(24, 'Mangrove saplings (1000)', 45000.00),
(24, 'Bamboo stakes',            15000.00),
(24, 'Protective netting',       18000.00),
(24, 'Volunteer meals',          25000.00),
(25, 'Diving equipment hire',    40000.00),
(25, 'Coral fragment trays',     10000.00),
(25, 'Underwater cameras',       15000.00),
(6,  'Tree saplings (500)',      30000.00),
(6,  'Planting tools',           15000.00),
(6,  'Volunteer shirts',         25000.00),
(6,  'Lunch packs',              20000.00);


-- ============================================================
-- 18. HIGHLIGHTS
-- ============================================================

INSERT INTO highlights (title, description, media_url, display_order, status) VALUES
('Hikkaduwa Coral Restoration 2024',  'Volunteers restored over 200 coral fragments in Hikkaduwa reef.',            '/V/uploads/highlights/coral1.jpg',    1, 'active'),
('Sinharaja Tree Planting Drive',     '66 volunteers planted 400 endemic trees at the Sinharaja buffer zone.',      '/V/uploads/highlights/trees1.jpg',    2, 'active'),
('Colombo Grand City Cleanup',        'Over 80 volunteers transformed Colombo Fort with a massive city cleanup.',   '/V/uploads/highlights/city1.jpg',     3, 'active'),
('Horton Plains Annual Cleanup',      'Annual mountain cleanup on the iconic Horton Plains trail.',                 '/V/uploads/highlights/mountain1.jpg', 4, 'active'),
('Puttalam Mangrove Restoration',     '58 volunteers replanted a 2km mangrove belt along Puttalam Lagoon.',        '/V/uploads/highlights/mangrove1.jpg', 5, 'active');



-- ============================================================
-- Representatives (IDs 23-42) → also insert into volunteer
-- ============================================================
INSERT INTO volunteer (userid, levelpoints, starpoints, noofmembers, dob, volunteer_experience, preferred_location_1, preferred_location_2, preferred_location_3) VALUES
(23, 500, 120, 4, '1992-03-10', '5 years, promoted to representative', 'Colombo',   'Gampaha',    'Negombo'),
(24, 520, 125, 4, '1991-07-22', '5 years, promoted to representative', 'Colombo',   'Kandy',      'Galle'),
(25, 480, 115, 3, '1993-05-14', '5 years, promoted to representative', 'Kandy',     'Colombo',    'Matale'),
(26, 510, 122, 4, '1990-11-30', '5 years, promoted to representative', 'Colombo',   'Gampaha',    'Kurunegala'),
(27, 490, 118, 3, '1992-08-19', '5 years, promoted to representative', 'Galle',     'Matara',     'Hambantota'),
(28, 530, 128, 4, '1991-02-07', '5 years, promoted to representative', 'Colombo',   'Negombo',    'Puttalam'),
(29, 470, 112, 3, '1993-12-25', '5 years, promoted to representative', 'Negombo',   'Colombo',    'Chilaw'),
(30, 545, 132, 4, '1990-06-16', '6 years, promoted to representative', 'Colombo',   'Kandy',      'Galle'),
(31, 460, 110, 3, '1994-04-03', '5 years, promoted to representative', 'Kandy',     'Nuwara Eliya','Badulla'),
(32, 515, 124, 4, '1991-09-11', '5 years, promoted to representative', 'Colombo',   'Gampaha',    'Kalutara'),
(33, 475, 114, 3, '1992-01-28', '5 years, promoted to representative', 'Galle',     'Hikkaduwa',  'Unawatuna'),
(34, 535, 130, 4, '1990-10-05', '6 years, promoted to representative', 'Colombo',   'Dehiwala',   'Nugegoda'),
(35, 485, 116, 3, '1993-07-17', '5 years, promoted to representative', 'Matara',    'Galle',      'Hambantota'),
(36, 500, 120, 4, '1991-03-24', '5 years, promoted to representative', 'Colombo',   'Kandy',      'Trincomalee'),
(37, 465, 111, 3, '1994-11-08', '5 years, promoted to representative', 'Negombo',   'Puttalam',   NULL),
(38, 550, 135, 5, '1989-08-31', '6 years, promoted to representative', 'Colombo',   'Galle',      'Kandy'),
(39, 480, 115, 3, '1992-06-13', '5 years, promoted to representative', 'Gampaha',   'Colombo',    'Kurunegala'),
(40, 495, 119, 3, '1991-12-20', '5 years, promoted to representative', 'Colombo',   'Negombo',    'Gampaha'),
(41, 455, 108, 3, '1993-09-02', '5 years, promoted to representative', 'Kandy',     'Colombo',    NULL),  -- suspended
(42, 460, 110, 3, '1994-02-15', '5 years, promoted to representative', 'Galle',     'Colombo',    'Matara'); -- suspended


-- ============================================================
-- Org Representatives (IDs 43-44) → also insert into volunteer
-- ============================================================
INSERT INTO volunteer (userid, levelpoints, starpoints, noofmembers, dob, volunteer_experience, preferred_location_1, preferred_location_2, preferred_location_3) VALUES
(43, 750, 185, 6, '1985-04-20', '8 years, promoted to org representative', 'Colombo', 'Galle',  'Kandy'),
(44, 780, 192, 7, '1983-11-09', '9 years, promoted to org representative', 'Colombo', 'Kandy',  'Gampaha');


-- ============================================================
-- Org Representatives (IDs 43-44) → also insert into representative
-- ============================================================
INSERT INTO representative (userid, duration, appointeddate, isorgrep, is_active) VALUES
(43, 24, '2021-06-01', 1, 1),
(44, 24, '2021-06-01', 1, 1);
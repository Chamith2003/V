<html>

<head>
    <title>V</title>
    <!-- <link rel="stylesheet" type="text/css" href="/V/View/globalstyles.css"> -->
    <link rel="stylesheet" type="text/css" href="/V/View/homepage/homepage.css">
    <?php include __DIR__ . '/../navbar/navbar.php'; ?>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
</head>

<body>
    

    <div class="homepageBox">
        <img src="/V/View/resources/homepagebg.png">
        <div class="homeHeading">Connect & Make a Difference Together</div>
        <div class="homeHeading homeSubHeading">Join our community of passionate volunteers and contribute to meaningful
            environmental projects in <br>Sri Lanka.</div>

    </div>

    <section class="howItWorksSection">
        <div class="howItWorksContainer">
            <h2 class="sectionTitle">How V Works</h2>
            <p class="sectionSubtitle">Getting started is simple. Join our community and begin making a difference in just three easy steps.</p>
            
            <div class="stepsContainer">
                <div class="step">
                     <?php if (!$isLoggedIn): ?><a href="/V/router.php?module=registration&action=register"><?php endif;  ?>
                        <div class="stepIcon">👤</div></a>
                    <h3 class="stepTitle">Create Your Profile</h3>
                    <p class="stepDescription">Set up your volunteer profile with your skills, interests, and availability to get matched with the perfect projects.</p>
                </div>
                <div class="step">
                    <a href="/V/router.php?module=projects&action=projects"><div class="stepIcon">🔍</div></a>
                    <h3 class="stepTitle">Find Projects</h3>
                    <p class="stepDescription">Browse through hundreds of environmental projects across Sri Lanka and find ones that match your passion and schedule.</p>
                </div>
                
                <div class="step">
                    <?php if ($isLoggedIn): ?><a href="/V/router.php?module=activity&action=activity"><?php endif;  ?>
                    <div class="stepIcon">🌍</div></a>
                    <h3 class="stepTitle">Make Impact</h3>
                    <p class="stepDescription">Join project teams, contribute your skills, and make a real difference in your community while connecting with like-minded volunteers.</p>
                </div>
                
            </div>
        </div>
    </section>



      <section class="highlightsSection">
        <div class="highlightsHeader">
            <h2 class="highlightsTitle">Project Highlights</h2>
            <p class="highlightsSubtitle">Discover the amazing impact our volunteers are making across Sri Lanka</p>
        </div>
        
        <div class="highlightsContainer" id="highlightsContainer">
            <button class="scrollControls scrollLeft" id="scrollLeft">‹</button>
            <button class="scrollControls scrollRight" id="scrollRight">›</button>
            
            <div class="highlightsTrack" id="highlightsTrack">
                <?php if (!empty($highlights)): ?>
                    <?php foreach ($highlights as $highlight): ?>
                        <div class="highlightCard">
                            <img src="<?= htmlspecialchars($highlight['media_url']) ?>" alt="<?= htmlspecialchars($highlight['title']) ?>" class="highlightMedia">
                            
                            <div class="highlightContent">
                            
                            <h3 class="highlightTitle"><?= htmlspecialchars($highlight['title']) ?></h3>
                    <p class="highlightDescription"><?= htmlspecialchars($highlight['description']) ?></p>
                            
                            </div>
                        </div>
                        <?php endforeach; ?>
                        <?php endif; ?>
                
            </div>
        </div>
    </section>
<section class="joinMovementSection">
        <div class="joinMovementContainer">
            <h2 class="joinMovementTitle">Ready to Make a Difference?</h2>
            <p class="joinMovementDescription"> We Care. We Act. We Change. </p>

<?php if ($isLoggedIn): ?><a href="/V/router.php?module=projects&action=projects"  class="joinMovementButton">Join the Movement</a>  <?php endif;  ?>
    <?php if (!$isLoggedIn): ?><a href="/V/router.php?module=registration&action=register"  class="joinMovementButton">Join the Movement</a>  <?php endif;  ?>
                    


            <!-- <a href="/V/router.php?module=registration&action=register" class="joinMovementButton">Join the Movement</a> -->
        </div>
    </section>

 <footer class="footer">
        <div class="footerContainer">
            <div class="footerContent">
                <div class="footerSection">
                    <h3>V</h3>
                    <p>Connecting passionate volunteers with meaningful environmental projects worldwide.</p>
                    <!-- <div class="socialLinks">
                        <a href="#" class="socialLink">
                            <img src="/V/View/resources/tktk.png">
                        </a>
                        <a href="#" class="socialLink">
                            <img src="/V/View/resources/insta.png">
                        </a>
                        <a href="#" class="socialLink">
                            <img src="/V/View/resources/fb.png">
                        </a>
                    </div> -->
                </div>
                <div class="footerSection">
                    <h3>Projects</h3>
                    <a href="/V/View/aboutus/aboutus.php#coraleventid">Beach Cleanups</a>
                    <a href="/V/View/aboutus/aboutus.php#mangroveeventid">Tree Planting</a>
                    <a href="/V/View/aboutus/aboutus.php#events">Coral Restoration</a>
                    <a href="/V/View/aboutus/aboutus.php#beacheventid">City Cleanups</a>
                </div>
                <div class="footerSection">
                    <h3>Projects</h3>
                    <a href="/V/View/aboutus/aboutus.php#cityeventid">Mountain Cleanups</a>
                    <a href="/V/View/aboutus/aboutus.php#mountaineventid">Mangrove Restoration</a>
                    
                    
                </div>
                <div class="footerSection">
                    <h3>Community</h3>
                    <a >Volunteers</a>
                    
                    <a >Events</a>
                    <a >Sponsors</a>
                </div>
                <!-- <div class="footerSection">
                    <h3>Support</h3>
                    <a href="#">Contact Us</a>
                </div> -->
            </div>
            <div class="footerBottom">
                <p>© 2024 V. All rights reserved. We Care. We Act. We Change.</p>
            </div>
        </div>
    </footer>

 <script src="/V/View/homepage/homepage.js"></script>
</body>



</html>
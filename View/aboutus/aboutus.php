<?php
$role = $_SESSION['role'] ?? '';
$eventsWithSponsors = $eventsWithSponsors ?? [];
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" type="text/css" href="/V/View/globalstyles.css">
    <!-- <link rel="stylesheet" href="/V/View/event_map/event_map.css"> -->
    <link rel="stylesheet" type="text/css" href="/V/View/aboutus/aboutus.css">
    <title>V</title>
    <!-- <1?php include __DIR__ . '/../navbar/navbar.php'; ?> -->
    <?php include __DIR__ . '/../navbar/navbar.php'; ?>






</head>

<body>
    <!-- Header -->
    <header>

    </header>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="container">
            <h1>About Our Mission</h1>
            <p>We Care. We Act. We Change.</p>
        </div>
    </section>

    <!-- About Introduction -->
    <section class="section" id="about">
        <div class="container">
            <div class="about-intro">
                <h3>What is V?</h3>
                <p>V is a revolutionary web-based platform designed to connect volunteers, organizers, and sponsors in
                    meaningful environmental and community service projects. Our mission is to make volunteering
                    accessible, rewarding, and impactful for everyone.</p>
                <p>We believe that when passionate individuals come together with proper tools and recognition, they can
                    create lasting positive change in their communities and the environment.</p>
            </div>

            <h2>Our Mission & Values</h2>
            <div class="mission">
                <div class="mission-text">
                    <h3>Why We Exist</h3>
                    <p>Despite volunteering being essential for community development, many areas lack a formal system
                        to connect volunteers, organizers, and sponsors. Current methods rely on verbal communication,
                        flyers, and social media, which often result in disorganized events and missed opportunities.
                    </p>
                    <div class="mission-highlight">
                        <strong>V solves this</strong> by providing a centralized, transparent, and user-friendly
                        platform that makes volunteering interesting, engaging, and meaningful for all participants.
                    </div>
                    <p>Through our innovative point system, badges, and recognition features, we transform volunteering
                        from a simple act into a rewarding journey of personal growth and community impact.</p>
                </div>
                <div>
                    <div class="values">
                        <div class="value-card">
                            <h4>Community</h4>
                            <p>Building strong connections among volunteers, organizers, and sponsors</p>
                        </div>
                        <div class="value-card">
                            <h4>Impact</h4>
                            <p>Creating measurable positive change in environmental projects</p>
                        </div>
                        <div class="value-card">
                            <h4>Recognition</h4>
                            <p>Celebrating volunteer contributions through badges and rewards</p>
                        </div>
                        <div class="value-card">
                            <h4>Transparency</h4>
                            <p>Maintaining clear communication and honest engagement</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php
    $eventsByType = [];

    foreach ($eventsWithSponsors as $event) {
        $type = trim($event['event_type']);
        $eventsByType[$type][] = $event;
    }
    ?>
    <!-- Events Section -->
    <section class="section" id="events">
        <div class="container">
            <h2>Our Featured Environmental Projects</h2>
            <div class="events-grid">
                <div class="event-card">
                    <div class="event-header">
                        <img src="/V/View/aboutus/coral.png" class="card-img">
                        <h3 id="coraleventid">Coral Restoration</h3>
                    </div>
                    <p>Help restore coral reefs along Sri Lanka's precious coastlines by actively participating in
                        marine ecosystem regeneration programs. Through careful coral planting, monitoring, and habitat
                        management, we work to revive these vital underwater ecosystems that support diverse marine
                        species and protect our shorelines from erosion and storm damage. Coral reefs are among the most
                        biodiverse ecosystems on Earth, providing food and shelter for thousands of species. Our
                        volunteers receive training in sustainable practices, learn about coral biology and climate
                        impacts, and directly contribute to reversing the damage caused by pollution and global warming.
                        Join us in creating thriving underwater gardens for future generations.</p>

                    <?php

                    $eventType = 'Coral Restoration';
                    $sponsors = $eventsByType[$eventType] ?? [];
                    ?>

                    <?php if (!empty($sponsors)): ?>
                        <div class="event-sponsors">
                            <div class="sponsor-title">

                                <span>Sponsored by</span>
                                <?php if ($role === 'sponsor'): ?>
                                    <a href="/V/router.php?module=projects&action=events&search=&location=&event_type=&date=&is_annual=1#events-section"
                                        class="sponsor-btn">Sponsor</a>
                                <?php endif; ?>
                            </div>
                            <div class="sponsor-logos">
                                <?php foreach ($sponsors as $event): ?>
                                    <?php if (!empty($event['sponsors'])): ?>
                                        <?php foreach ($event['sponsors'] as $sponsor): ?>

                                            <?php if (!empty($sponsor['official_website_link'])): ?>
                                                <a href="<?php echo htmlspecialchars($sponsor['official_website_link']); ?>" target="_blank"
                                                    rel="noopener noreferrer">
                                                    <img src="<?php echo htmlspecialchars($sponsor['logo_path']); ?>"
                                                        alt="<?php echo htmlspecialchars($sponsor['sponsor_name']); ?>"
                                                        title="<?php echo htmlspecialchars($sponsor['sponsor_name']); ?>">
                                                </a>
                                            <?php else: ?>
                                                <img src="<?php echo htmlspecialchars($sponsor['logo_path']); ?>"
                                                    alt="<?php echo htmlspecialchars($sponsor['sponsor_name']); ?>"
                                                    title="<?php echo htmlspecialchars($sponsor['sponsor_name']); ?>">
                                            <?php endif; ?>


                                            <!-- <img src="<?php echo htmlspecialchars($sponsor['logo_path']); ?>"
                                                alt="<?php echo htmlspecialchars($sponsor['sponsor_name']); ?>"
                                                title="<?php echo htmlspecialchars($sponsor['sponsor_name']); ?>"> -->
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>


                        </div>
                    <?php endif; ?>
                    <!-- <div class="event-sponsors">
                        <span class="sponsor-title">Sponsored by</span>
                        <div class="sponsor-logos">
                            <img src="/V/uploads/sponsor_logos/sponsor_122_1766898048" alt="Sponsor 1">
                            <img src="/V/uploads/sponsor_logos/sponsor_121_1766897405" alt="Sponsor 2">
                            <img src="/V/View/sponsors/sponsor3.png" alt="Sponsor 3">
                        </div>
                    </div> -->


                </div>

                <div class="event-card">
                    <div class="event-header">
                        <img src="/V/View/aboutus/beach.png" class="card-img">
                        <h3 id="beacheventid">Beach Cleanup</h3>
                    </div>
                    <p>Join our comprehensive beach cleanup initiatives to remove plastic waste, debris, and
                        microplastics from our pristine Sri Lankan shores. These regular cleanup drives, organized
                        throughout the year, help protect endangered marine life, preserve the natural beauty of our
                        coastal ecosystems, and raise community awareness about the devastating effects of ocean
                        pollution and plastic waste management. Volunteers work together to collect and properly
                        dispose
                        of waste, educate locals about sustainable practices, and monitor beach health. Your
                        participation directly contributes to healthier oceans, cleaner habitats for marine
                        organisms,
                        and a more sustainable future for our island nation.</p>

                    <?php

                    $eventType = 'Beach Cleanup';
                    $sponsors = $eventsByType[$eventType] ?? [];
                    ?>

                    <?php if (!empty($sponsors)): ?>
                        <div class="event-sponsors">
                            <div class="sponsor-title">

                                <span>Sponsored by</span>
                                <?php if ($role === 'sponsor'): ?>
                                    <a href="/V/router.php?module=projects&action=events&search=&location=&event_type=&date=&is_annual=1#events-section"
                                        class="sponsor-btn">Sponsor</a>
                                <?php endif; ?>
                            </div>
                            <div class="sponsor-logos">
                                <?php foreach ($sponsors as $event): ?>
                                    <?php if (!empty($event['sponsors'])): ?>
                                        <?php foreach ($event['sponsors'] as $sponsor): ?>
                                            <?php if (!empty($sponsor['official_website_link'])): ?>
                                                <a href="<?php echo htmlspecialchars($sponsor['official_website_link']); ?>" target="_blank"
                                                    rel="noopener noreferrer">
                                                    <img src="<?php echo htmlspecialchars($sponsor['logo_path']); ?>"
                                                        alt="<?php echo htmlspecialchars($sponsor['sponsor_name']); ?>"
                                                        title="<?php echo htmlspecialchars($sponsor['sponsor_name']); ?>">
                                                </a>
                                            <?php else: ?>
                                                <img src="<?php echo htmlspecialchars($sponsor['logo_path']); ?>"
                                                    alt="<?php echo htmlspecialchars($sponsor['sponsor_name']); ?>"
                                                    title="<?php echo htmlspecialchars($sponsor['sponsor_name']); ?>">
                                            <?php endif; ?>


                                            <!-- <img src="<?php echo htmlspecialchars($sponsor['logo_path']); ?>"
                                                alt="<?php echo htmlspecialchars($sponsor['sponsor_name']); ?>"
                                                title="<?php echo htmlspecialchars($sponsor['sponsor_name']); ?>"> -->
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- <div class="event-sponsors">
                        <span class="sponsor-title">Sponsored by</span>
                        <div class="sponsor-logos">
                            <img src="/V/uploads/sponsor_logos/sponsor_122_1766898048" alt="Sponsor 1">
                            <img src="/V/uploads/sponsor_logos/sponsor_121_1766897405" alt="Sponsor 2">
                            <img src="/V/View/sponsors/sponsor3.png" alt="Sponsor 3">
                        </div>
                    </div> -->

                </div>

                <div class="event-card">
                    <div class="event-header">
                        <img src="/V/View/aboutus/city.png" class="card-img">
                        <h3 id="cityeventid">City Cleanup</h3>
                    </div>
                    <p>Participate in community-led waste management projects that establish recycling centers and
                        significantly reduce landfill burden in urban areas across Sri Lanka. These initiatives
                        focus on
                        educating residents about proper waste segregation, composting, and sustainable consumption
                        practices while establishing functional recycling infrastructure. We work directly with
                        local
                        communities to implement comprehensive waste reduction strategies, targeting a 60% reduction
                        in
                        landfill waste through practical programs and continuous education. Volunteers help organize
                        collection drives, operate recycling facilities, conduct community workshops on
                        environmental
                        responsibility, and monitor waste management progress. Your involvement strengthens
                        community
                        bonds, creates employment opportunities in the green sector, and builds a foundation for a
                        cleaner, more sustainable urban environment for all.</p>

                    <?php

                    $eventType = 'City Cleanup';
                    $sponsors = $eventsByType[$eventType] ?? [];
                    ?>

                    <?php if (!empty($sponsors)): ?>
                        <div class="event-sponsors">
                            <div class="sponsor-title">

                                <span>Sponsored by</span><?php if ($role === 'sponsor' ): ?>   
                                <a href="/V/router.php?module=projects&action=events&search=&location=&event_type=&date=&is_annual=1#events-section" class="sponsor-btn">Sponsor</a>
                                <?php endif; ?>
                            </div>
                            <div class="sponsor-logos">
                                <?php foreach ($sponsors as $event): ?>
                                    <?php if (!empty($event['sponsors'])): ?>
                                        <?php foreach ($event['sponsors'] as $sponsor): ?>

                                            <?php if (!empty($sponsor['official_website_link'])): ?>
                                                <a href="<?php echo htmlspecialchars($sponsor['official_website_link']); ?>" target="_blank"
                                                    rel="noopener noreferrer">
                                                    <img src="<?php echo htmlspecialchars($sponsor['logo_path']); ?>"
                                                        alt="<?php echo htmlspecialchars($sponsor['sponsor_name']); ?>"
                                                        title="<?php echo htmlspecialchars($sponsor['sponsor_name']); ?>">
                                                </a>
                                            <?php else: ?>
                                                <img src="<?php echo htmlspecialchars($sponsor['logo_path']); ?>"
                                                    alt="<?php echo htmlspecialchars($sponsor['sponsor_name']); ?>"
                                                    title="<?php echo htmlspecialchars($sponsor['sponsor_name']); ?>">
                                            <?php endif; ?>
                                            <!--                                             
                                            <img src="<?php echo htmlspecialchars($sponsor['logo_path']); ?>"
                                                alt="<?php echo htmlspecialchars($sponsor['sponsor_name']); ?>"
                                                title="<?php echo htmlspecialchars($sponsor['sponsor_name']); ?>"> -->
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>

                            </div>

                        </div>
                    <?php endif; ?>
                    <!-- <div class="event-sponsors">
                        <span class="sponsor-title">Sponsored by</span>
                        <div class="sponsor-logos">
                            <img src="/V/uploads/sponsor_logos/sponsor_122_1766898048" alt="Sponsor 1">
                            <img src="/V/uploads/sponsor_logos/sponsor_121_1766897405" alt="Sponsor 2">
                            <img src="/V/View/sponsors/sponsor3.png" alt="Sponsor 3">
                        </div>
                    </div> -->

                </div>

                <div class="event-card">
                    <div class="event-header">
                        <img src="/V/View/aboutus/mountain.png" class="card-img">
                        <h3 id="mountaineventid">Mountain Cleanup</h3>
                    </div>
                    <p>Help maintain the pristine conditions of Sri Lanka's breathtaking mountain regions by
                        actively
                        removing litter, invasive species, and environmental hazards that threaten these fragile
                        ecosystems. Mountain cleanup projects protect alpine environments, preserve critical natural
                        habitats for endemic wildlife species, and ensure sustainable tourism practices. Our
                        volunteers
                        work at various altitudes to collect waste abandoned by hikers and tourists, remove invasive
                        plant species that choke native vegetation, and restore degraded trails. These efforts
                        prevent
                        soil erosion, protect water sources, and maintain the ecological integrity of our highlands.
                        Participants gain valuable mountain conservation knowledge, build community bonds through
                        shared
                        environmental stewardship, and witness the transformative impact of collective action on
                        preserving Sri Lanka's natural heritage for future generations to enjoy.</p>

                    <?php

                    $eventType = 'Mountain Cleanup';
                    $sponsors = $eventsByType[$eventType] ?? [];
                    ?>

                    <?php if (!empty($sponsors)): ?>
                        <div class="event-sponsors">
                            <div class="sponsor-title">

                                <span>Sponsored by</span> <?php if ($role === 'sponsor' ): ?>   
                                <a href="/V/router.php?module=projects&action=events&search=&location=&event_type=&date=&is_annual=1#events-section" class="sponsor-btn">Sponsor</a>
                                <?php endif; ?>
                            </div>
                            <div class="sponsor-logos">
                                <?php foreach ($sponsors as $event): ?>
                                    <?php if (!empty($event['sponsors'])): ?>
                                        <?php foreach ($event['sponsors'] as $sponsor): ?>

                                            <?php if (!empty($sponsor['official_website_link'])): ?>
                                                <a href="<?php echo htmlspecialchars($sponsor['official_website_link']); ?>" target="_blank"
                                                    rel="noopener noreferrer">
                                                    <img src="<?php echo htmlspecialchars($sponsor['logo_path']); ?>"
                                                        alt="<?php echo htmlspecialchars($sponsor['sponsor_name']); ?>"
                                                        title="<?php echo htmlspecialchars($sponsor['sponsor_name']); ?>">
                                                </a>
                                            <?php else: ?>
                                                <img src="<?php echo htmlspecialchars($sponsor['logo_path']); ?>"
                                                    alt="<?php echo htmlspecialchars($sponsor['sponsor_name']); ?>"
                                                    title="<?php echo htmlspecialchars($sponsor['sponsor_name']); ?>">
                                            <?php endif; ?>

                                            <!-- <img src="<?php echo htmlspecialchars($sponsor['logo_path']); ?>"
                                                alt="<?php echo htmlspecialchars($sponsor['sponsor_name']); ?>"
                                                title="<?php echo htmlspecialchars($sponsor['sponsor_name']); ?>"> -->
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>


                    <!-- <div class="event-sponsors">
                        <span class="sponsor-title">Sponsored by</span>
                        <div class="sponsor-logos">
                            <img src="/V/uploads/sponsor_logos/sponsor_122_1766898048" alt="Sponsor 1">
                            <img src="/V/uploads/sponsor_logos/sponsor_121_1766897405" alt="Sponsor 2">
                            <img src="/V/View/sponsors/sponsor3.png" alt="Sponsor 3">
                        </div>
                    </div> -->


                </div>


                <div class="event-card">
                    <div class="event-header">
                        <img src="/V/View/aboutus/mangrove.png" class="card-img">
                        <h3 id="mangroveeventid">Mangrove Restoration</h3>
                    </div>
                    <p>Restore vital mangrove forests that serve as natural coastal protection barriers and crucial
                        breeding grounds for numerous marine and bird species. Mangroves are extraordinary
                        ecosystems
                        adapted to thrive in saltwater environments, providing food security and livelihoods for
                        coastal
                        communities while playing a critical role in combating climate change through carbon
                        sequestration. Our volunteers participate in mangrove planting initiatives, learn about
                        their
                        ecological significance, and engage in habitat restoration work that strengthens coastal
                        resilience against storms and rising sea levels. Mangrove conservation directly supports
                        fish
                        populations, protects against tsunami damage, and creates economic opportunities through
                        sustainable practices. By joining this project, you contribute to preserving these
                        remarkable
                        forests that have sustained human communities for centuries while safeguarding marine
                        biodiversity and our coastal future.</p>


                    <?php

                    $eventType = 'Mangrove Restoration';
                    $sponsors = $eventsByType[$eventType] ?? [];
                    ?>

                    <?php if (!empty($sponsors)): ?>
                        <div class="event-sponsors">
                            <div class="sponsor-title">

                                <span>Sponsored by</span> <?php if ($role === 'sponsor' ): ?>   
                                <a href="/V/router.php?module=projects&action=events&search=&location=&event_type=&date=&is_annual=1#events-section" class="sponsor-btn">Sponsor</a>
                                <?php endif; ?>
                            </div>

                            <div class="sponsor-logos">
                                <?php foreach ($sponsors as $event): ?>
                                    <?php if (!empty($event['sponsors'])): ?>
                                        <?php foreach ($event['sponsors'] as $sponsor): ?>

                                            <?php if (!empty($sponsor['official_website_link'])): ?>
                                                <a href="<?php echo htmlspecialchars($sponsor['official_website_link']); ?>" target="_blank"
                                                    rel="noopener noreferrer">
                                                    <img src="<?php echo htmlspecialchars($sponsor['logo_path']); ?>"
                                                        alt="<?php echo htmlspecialchars($sponsor['sponsor_name']); ?>"
                                                        title="<?php echo htmlspecialchars($sponsor['sponsor_name']); ?>">
                                                </a>
                                            <?php else: ?>
                                                <img src="<?php echo htmlspecialchars($sponsor['logo_path']); ?>"
                                                    alt="<?php echo htmlspecialchars($sponsor['sponsor_name']); ?>"
                                                    title="<?php echo htmlspecialchars($sponsor['sponsor_name']); ?>">
                                            <?php endif; ?>


                                            <!-- <img src="<?php echo htmlspecialchars($sponsor['logo_path']); ?>"
                                                alt="<?php echo htmlspecialchars($sponsor['sponsor_name']); ?>"
                                                title="<?php echo htmlspecialchars($sponsor['sponsor_name']); ?>"> -->
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>

                        </div>
                    <?php endif; ?>


                    <!-- <div class="event-sponsors">
                        <span class="sponsor-title">Sponsored by</span>
                        <div class="sponsor-logos">
                            <img src="/V/uploads/sponsor_logos/sponsor_122_1766898048" alt="Sponsor 1">
                            <img src="/V/uploads/sponsor_logos/sponsor_121_1766897405" alt="Sponsor 2">
                            <img src="/V/View/sponsors/sponsor3.png" alt="Sponsor 3">
                        </div>
                    </div> -->

                </div>

                <div class="event-card">
                    <div class="event-header">
                        <img src="/V/View/aboutus/tree.png" class="card-img">
                        <h3 id="treeeventid">Tree Planting</h3>
                    </div>
                    <p>Plant native trees across Sri Lanka to combat deforestation, climate change, and habitat loss
                        affecting our nation's biodiversity. Each tree planted represents a significant investment
                        in
                        our future, contributing to carbon sequestration, improved air quality, wildlife habitat
                        restoration, and sustainable forest management. Our volunteers learn about native species
                        selection, proper planting techniques, and long-term tree care while directly participating
                        in
                        reforestation efforts across various regions. Trees combat climate change by absorbing
                        carbon
                        dioxide, provide shelter for endangered wildlife species, prevent soil erosion, improve
                        water
                        quality, and enhance community resilience. Beyond environmental benefits, tree planting
                        creates
                        green spaces for recreation, improves mental health through nature connection, and
                        strengthens
                        community bonds. Join us in planting the forests that will sustain and inspire future
                        generations while healing our planet.</p>

                    <?php

                    $eventType = 'Tree Planting';
                    $sponsors = $eventsByType[$eventType] ?? [];
                    ?>

                    <?php if (!empty($sponsors)): ?>
                        <div class="event-sponsors">
                            <div class="sponsor-title">

                                <span>Sponsored by</span> <?php if ($role === 'sponsor' ): ?>   
                                <a href="/V/router.php?module=projects&action=events&search=&location=&event_type=&date=&is_annual=1#events-section" class="sponsor-btn">Sponsor</a>
                                <?php endif; ?>
                            </div>
                            <div class="sponsor-logos">
                                <?php foreach ($sponsors as $event): ?>
                                    <?php if (!empty($event['sponsors'])): ?>
                                        <?php foreach ($event['sponsors'] as $sponsor): ?>

                                            <?php if (!empty($sponsor['official_website_link'])): ?>
                                                <a href="<?php echo htmlspecialchars($sponsor['official_website_link']); ?>" target="_blank"
                                                    rel="noopener noreferrer">
                                                    <img src="<?php echo htmlspecialchars($sponsor['logo_path']); ?>"
                                                        alt="<?php echo htmlspecialchars($sponsor['sponsor_name']); ?>"
                                                        title="<?php echo htmlspecialchars($sponsor['sponsor_name']); ?>">
                                                </a>
                                            <?php else: ?>
                                                <img src="<?php echo htmlspecialchars($sponsor['logo_path']); ?>"
                                                    alt="<?php echo htmlspecialchars($sponsor['sponsor_name']); ?>"
                                                    title="<?php echo htmlspecialchars($sponsor['sponsor_name']); ?>">
                                            <?php endif; ?>


                                            <!-- <img src="<?php echo htmlspecialchars($sponsor['logo_path']); ?>"
                                                alt="<?php echo htmlspecialchars($sponsor['sponsor_name']); ?>"
                                                title="<?php echo htmlspecialchars($sponsor['sponsor_name']); ?>"> -->
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- <div class="event-sponsors">
                        <span class="sponsor-title">Sponsored by</span>
                        <div class="sponsor-logos">
                            <img src="/V/uploads/sponsor_logos/sponsor_122_1766898048" alt="Sponsor 1">
                            <img src="/V/uploads/sponsor_logos/sponsor_121_1766897405" alt="Sponsor 2">
                            <img src="/V/View/sponsors/sponsor3.png" alt="Sponsor 3">
                        </div>
                    </div> -->

                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-section" id="contact">
        <div class="container">
            <h2>Get In Touch</h2>

            <div class="contact-grid">
                <div class="contact-item">
                    <h4> Email</h4>
                    <p><a href="mailto:contact@vplatform.lk">contact@vplatform.lk</a></p>
                    <p><a href="mailto:support@vplatform.lk">support@vplatform.lk</a></p>
                </div>

                <div class="contact-item">
                    <h4> Phone</h4>
                    <p><a href="tel:+94112345678">+94 11 234 5678</a></p>
                    <p><a href="tel:+94776543210">+94 77 654 3210</a></p>
                </div>

                <div class="contact-item">
                    <h4> Location</h4>
                    <p>Colombo, Sri Lanka</p>
                    <p>Open Monday - Friday, 9:00 AM - 6:00 PM</p>
                </div>
            </div>

            <div class="contact-form" id="contact">
                <h3 style="text-align: center; margin-bottom: 20px; color: #53998E;">Send us a Message</h3>
                <div id="contactMessage"
                    style="display: none; padding: 12px 18px; border-radius: 8px; margin-bottom: 15px; font-weight: 500;">
                </div>
                <form id="contactForm">
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <input type="text" id="subject" name="subject" required>
                    </div>
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea id="message" name="message" required></textarea>
                    </div>
                    <button type="submit" class="submit-btn" id="submitContactBtn">Send Message</button>
                </form>
            </div>

            <div style="text-align: center; margin-top: 40px;">
                <h4>Follow Us</h4>
                <div class="social-links">
                    <a href="#">Facebook</a>
                    <a href="#">Instagram</a>
                    <a href="#">Twitter</a>
                    <a href="#">LinkedIn</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p><strong>V - A Platform for Volunteers to Ignite Change</strong></p>
            <p>Connecting passionate volunteers, organizers, and sponsors to make a difference in Sri Lanka</p>
            <div class="social-links">
                <a href="#">f</a>
                <a href="#">@</a>
                <a href="#">in</a>
            </div>
            <p style="margin-top: 20px; font-size: 14px;">© 2025 V Platform. All rights reserved. | We Care. We Act. We
                Change.</p>
        </div>
    </footer>
    <script src="/V/View/aboutus/aboutus.js"></script>


</body>

</html>
<?php
// Display error if exists
$error = $_SESSION['error'] ?? '';
if ($error) {
    echo "<script>alert('{$error}');</script>";
    unset($_SESSION['error']);
}
$role = $_SESSION['registration_role'] ?? 'sponsor';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>V</title>
    <!-- <link rel="stylesheet" href="registration.css"> -->
    <link rel="stylesheet" type="text/css" href="/V/View/registration/registration.css">
</head>

<body>
    <div class="container">
        <!-- Progress Steps -->
        <div class="progress">
            <h2>Join Our Community</h2>
            <p>Create your environmental volunteer account</p>


            <?php if ($role == 'sponsor'): ?>
                <div class="steps">
                    <div class="circle">1</div>
                    <div class="line"></div>
                    <div class="circle">2</div>
                    <div class="line"></div>
                    <div class="circle active">3</div>

                </div>
            <?php endif; ?>
        </div>

        <!-- Form Card -->
        <div class="form-card">
            <div class="form-header">
                <h3>Sponsor Information</h3>
                <span class="step-text">Step 3 of 3</span>
            </div>
            <!-- <p class="sub-text">Password verification </p> -->
            <p class="sub-text">Upload your Organization / Company logo </p>

            <!-- <form> -->
            <form method="POST" action="/V/router.php?module=registration&action=s_registration_step3"
                enctype="multipart/form-data">
                <div class="logo-upload-wrapper">
                    <!-- Upload Box -->

                    <div class="upload-container">
                        <label for="file-upload" class="custom-upload-box">
                            <div class="icon-container">
                                <img class="upload" src="/V/View/registration/sponsor/upload.png" alt="upload" />
                            </div>
                            <span class="upload-text"><strong>Click to upload</strong> or drag and drop</span>
                            <span class="upload-hint">PNG, JPG or SVG (Max 2MB)</span>

                            <input type="file" id="file-upload" name="logo" accept=".png, .jpg, .jpeg, .svg" />

                        </label>
                        <div id="preview-card" class="preview-card" style="display: none;">
                            <div class="preview-content">
                                <img id="logo-preview" src="#" alt="Logo Preview" />
                                <div class="file-info">
                                    <span id="display-name" class="file-name">filename.png</span>
                                    <span class="status-text">Ready for upload</span>
                                </div>
                                <button type="button" id="remove-btn" class="btn-remove" title="Remove image">✕</button>
                            </div>
                        </div>
                    </div>


                    <!-- Description -->
                    <div class="logo-description">
                        <h4>Why we need your logo</h4>
                        <p>
                            This logo will be proudly displayed at all annual events you sponsor for donations of
                            <strong>LKR 25,000 or above</strong>, helping volunteers recognize and appreciate your
                            support.
                        </p>

                    </div>
                </div>
                <div class="terms">
                    <input type="checkbox" name="terms" required>
                    <label>I agree to the
                        <a href="#" class="terms-link" onclick="openModal('terms-modal'); return false;">Terms and
                            Conditions</a>
                        and
                        <a href="#" class="terms-link" onclick="openModal('privacy-modal'); return false;">Privacy
                            Policy</a>,
                        and allow my organization’s logo to be displayed on sponsored events
                    </label>

                </div>
                <div class="form-footer">

                    <button type="button" class="btn-previous"
                        onclick="window.location.href='/V/router.php?module=registration&action=s_registration_step2'">
                        ← Previous
                    </button>
                    <button type="submit" class="btn-next">Create Account</button>


                </div>
            </form>
        </div>
    </div>

    <!-- Terms and Conditions Modal -->
<div id="terms-modal" class="modal-overlay" onclick="closeModalOutside(event, 'terms-modal')">
    <div class="modal-box">
        <div class="modal-header">
            <h3>Terms and Conditions</h3>
            <button class="modal-close" onclick="closeModal('terms-modal')">✕</button>
        </div>
        <div class="modal-body">
            <p class="modal-date">Last updated: April 2026</p>

            <h4>1. About the V Platform</h4>
            <p>V is an environmental volunteer platform that connects sponsors with community-driven conservation events across Sri Lanka. By registering as a sponsor, you agree to support our mission of environmental protection and community engagement.</p>

            <h4>2. Sponsor Eligibility</h4>
            <p>To register as a sponsor, you must:</p>
            <ul>
                <li>Be a legally registered organization or company.</li>
                <li>Provide accurate and truthful information during registration.</li>
                <li>Agree to comply with all applicable laws and regulations in Sri Lanka.</li>
            </ul>

            <h4>3. Logo Usage & Display</h4>
            <p>By uploading your organization's logo, you grant V a non-exclusive, royalty-free license to display your logo at events and on promotional materials where your sponsorship applies. Your logo will be displayed at all annual events you sponsor for donations of <strong>LKR 25,000 or above</strong>.</p>
            <ul>
                <li>You confirm that you own or have rights to the logo you upload.</li>
                <li>V reserves the right to remove logos that violate our guidelines or community values.</li>
                <li>Logo display is tied to active sponsorship status only.</li>
            </ul>

            <h4>4. Sponsorship & Donations</h4>
            <p>All sponsorship contributions made through V are used exclusively to fund environmental volunteer events and initiatives. V does not guarantee specific event outcomes or attendance numbers. Sponsorship amounts are non-refundable once an event has commenced.</p>

            <h4>5. Account Responsibilities</h4>
            <p>You are responsible for maintaining the confidentiality of your account credentials. You agree not to misrepresent your organization or use the platform for any fraudulent, misleading, or harmful activities. V reserves the right to suspend or terminate accounts that violate these terms.</p>

            <h4>6. Intellectual Property</h4>
            <p>All content on the V platform, including design, branding, and materials, is the intellectual property of V. Sponsors may not reproduce or distribute V's materials without prior written consent.</p>

            <h4>7. Limitation of Liability</h4>
            <p>V shall not be held liable for any indirect, incidental, or consequential damages arising from your use of the platform or participation in sponsored events. Our liability is limited to the extent permitted by Sri Lankan law.</p>

            <h4>8. Changes to Terms</h4>
            <p>V reserves the right to update these Terms and Conditions at any time. Continued use of the platform after changes constitutes your acceptance of the revised terms.</p>

            <h4>9. Contact Us</h4>
            <p>For any queries regarding these terms, please contact us through the V platform's official support channels.</p>
        </div>
        <div class="modal-footer">
            <button class="btn-modal-close" onclick="closeModal('terms-modal')">Close</button>
        </div>
    </div>
</div>

<!-- Privacy Policy Modal -->
<div id="privacy-modal" class="modal-overlay" onclick="closeModalOutside(event, 'privacy-modal')">
    <div class="modal-box">
        <div class="modal-header">
            <h3>Privacy Policy</h3>
            <button class="modal-close" onclick="closeModal('privacy-modal')">✕</button>
        </div>
        <div class="modal-body">
            <p class="modal-date">Last updated: April 2026</p>

            <h4>1. Information We Collect</h4>
            <p>When you register as a sponsor on V, we collect:</p>
            <ul>
                <li>Organization name, contact details, and registration information.</li>
                <li>Your organization's logo and branding materials.</li>
                <li>Sponsorship transaction details.</li>
            </ul>

            <h4>2. How We Use Your Information</h4>
            <p>We use the information you provide to:</p>
            <ul>
                <li>Create and manage your sponsor account.</li>
                <li>Display your logo at relevant sponsored events.</li>
                <li>Communicate with you about events, updates, and sponsorship opportunities.</li>
                <li>Improve the V platform experience.</li>
            </ul>

            <h4>3. Logo & Branding Display</h4>
            <p>Your uploaded logo will be publicly displayed at events you sponsor. By submitting your logo, you consent to this public display as part of the sponsorship agreement.</p>

            <h4>4. Data Sharing</h4>
            <p>V does not sell or rent your personal or organizational data to third parties. We may share your information with event organizers and volunteers solely for the purpose of coordinating sponsored events.</p>

            <h4>5. Data Security</h4>
            <p>We take reasonable technical and organizational measures to protect your data from unauthorized access, disclosure, or loss. However, no system is entirely secure, and we cannot guarantee absolute security.</p>

            <h4>6. Data Retention</h4>
            <p>We retain your account data for as long as your sponsorship account remains active. You may request deletion of your data by contacting V support, subject to legal retention requirements.</p>

            <h4>7. Your Rights</h4>
            <p>You have the right to access, correct, or request deletion of your personal data. To exercise these rights, please contact us through the V platform's official support channels.</p>

            <h4>8. Contact</h4>
            <p>For privacy-related concerns, please reach out via the official V platform support page.</p>
        </div>
        <div class="modal-footer">
            <button class="btn-modal-close" onclick="closeModal('privacy-modal')">Close</button>
        </div>
    </div>
</div>
    <script src="/V/View/registration/sponsor/sponsor.js"></script>

</body>

</html>
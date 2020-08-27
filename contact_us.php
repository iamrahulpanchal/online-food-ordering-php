<?php 

include('top.inc.php');

?>

<div class="breadcrumb-area gray-bg">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="index">Home</a></li>
                <li class="active">Contact Us</li>
            </ul>
        </div>
    </div>
</div>
<div class="contact-area pt-100 pb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6 col-12">
                <div class="contact-info-wrapper text-center mb-30">
                    <div class="contact-info-icon">
                        <i class="ion-ios-location-outline"></i>
                    </div>
                    <div class="contact-info-content">
                        <h4>Our Location</h4>
                        <p>012 345 678 / 123 456 789</p>
                        <p><a href="#">rahulnpanchal50@gmail.com</a></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <div class="contact-info-wrapper text-center mb-30">
                    <div class="contact-info-icon">
                        <i class="ion-ios-telephone-outline"></i>
                    </div>
                    <div class="contact-info-content">
                        <h4>Contact us Anytime</h4>
                        <p>Mobile: 123 456 7890</p>
                        <p>Fax: 123 456 789</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <div class="contact-info-wrapper text-center mb-30">
                    <div class="contact-info-icon">
                        <i class="ion-ios-email-outline"></i>
                    </div>
                    <div class="contact-info-content">
                        <h4>Write Some Words</h4>
                        <p><a href="#">Support24/7@example.com </a></p>
                        <p><a href="#">info@example.com</a></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="contact-message-wrapper">
                    <h4 class="contact-title">GET IN TOUCH</h4>
                    <div class="contact-message">
                        <form id="contact-form" method="post">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="contact-form-style mb-20">
                                        <input name="cu_name" id="cu_name" placeholder="Full Name" type="text" required />
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="contact-form-style mb-20">
                                        <input name="cu_email" id="cu_email" placeholder="Email Address" type="text" required />
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="contact-form-style mb-20">
                                        <input name="cu_subject" id="cu_subject" placeholder="Subject" type="text" required />
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="contact-form-style">
                                        <textarea name="cu_message" id="cu_message" placeholder="Message" required></textarea>
                                        <button class="submit btn-style" type="submit" onclick="contact_submit()">SEND MESSAGE</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- <p class="form-messege"></p> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include('footer.inc.php'); ?>
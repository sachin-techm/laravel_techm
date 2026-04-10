

<?php $__env->startSection('content'); ?>
    <!-- Hero Section -->
    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="<?php echo e(asset('assets/frontend/images/slider-1.jpg')); ?>" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>First slide label</h5>
                    <p>Some representative placeholder content for the first slide.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="<?php echo e(asset('assets/frontend/images/slider-2.jpg')); ?>" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Second slide label</h5>
                    <p>Some representative placeholder content for the second slide.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="<?php echo e(asset('assets/frontend/images/slider-3.jpg')); ?>" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Third slide label</h5>
                    <p>Some representative placeholder content for the third slide.</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <!-- <section class="hero">
        <div>
            <img src="<?php echo e(asset('assets/frontend/images/RCLS_logo.png')); ?>" height="250px;">
            <h1>Way Towards Innovative, Efficient & <br>Smart Digital Solutions</h1>
            <p>The 2024 Edition was a massive success and we now look forward to the 2025 Edition. <br/>In case of any interest, please get in touch with us.</p>
        </div>
    </section> -->

    <!-- About Us Section -->
    <section class="about-section py-5">
        <div class="container">
            <div class="row align-items-center">
                
                <!-- Left Image -->
                <div class="col-md-6">
                    <img src="<?php echo e(asset('assets/frontend/images/software-engineers-working-on-project-4.webp')); ?>" 
                         class="img-fluid rounded" 
                         alt="About Image">
                </div>

                <!-- Right Content -->
                <div class="col-md-6">
                    <h2 class="mb-3">About TechMistriz</h2>
                    <p>
                        TechMistriz is one of the leading website development and digital marketing companies in India, offering solutions for many years. At TechMistriz, we are committed to providing the best quality service using the latest technology and a wide range of creativity. We collaborate with our clients from start to finish to ensure they receive exactly what they need and want. Whether you’re looking for SEO, web design and development, content marketing, pay-per-click advertising, or social media marketing, our expert team will help you achieve your goals.
                    </p>
                    <div class="row mt-3">
                        <div class="col-6">
                            <ul class="check-list">
                                <li>Advanced Techniques</li>
                                <li>Customer Service</li>
                                <li>24/7 Support</li>
                            </ul>
                        </div>
                        <div class="col-6">
                            <ul class="check-list">
                                <li>Experienced Team</li>
                                <li>Quick Solutions</li>
                                <li>Effective Results</li>
                            </ul>
                        </div>
                    </div>
                    <div class="vm-box p-4 bg-light" style="border-left: 5px solid #0598ce;">
                        <p>“TechMistriz is an excellent choice for those looking for the best digital marketing agency in Noida. TechMistriz has many years of experience in the digital marketing industry, but it also provides a wide range of web development services in Noida.”</p>
                    </div>
                    <a href="/about" class="btn-contact">About Us</a>
                </div>

            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="services" id="services">
        <h2>Our Services</h2>
        <div class="service">
            <div class="service-item">
                <h3>Web Development</h3>
                <p>We create websites that add value to businesses. Our website designs are created with the goal of converting potential customers into prospects and then into paying customers.</p>
            </div>
            <div class="service-item">
                <h3>Website Design</h3>
                <p>We understand the market, so by integrating best practices of UX designs that include development activities, we provide you with an unrivaled experience.</p>
            </div>
            <div class="service-item">
                <h3>Digital Marketing Services</h3>
                <p>We are a results-driven digital agency that creates and develops digital marketing strategies and campaigns in areas such as digital strategy and branding, social media, e-commerce, and more.</p>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about" id="about">
        <h2>About Us</h2>
        <p>We are a team of professionals dedicated to providing the best solutions to our clients. Our mission is to deliver excellence in everything we do.</p>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials" id="testimonials">
        <h2>What Our Clients Say</h2>
        <div class="testimonial-item">
            <p>"This company is amazing! They exceeded all my expectations."</p>
            <h3>- Sachin Verma</h3>
        </div>
        <div class="testimonial-item">
            <p>"Outstanding service and support. Highly recommended!"</p>
            <h3>- Tarun Sharma</h3>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact" id="contact">
        <h2>Contact Us</h2>
        <form>
            <input type="text" name="name" placeholder="Your Name" required>
            <input type="email" name="email" placeholder="Your Email" required>
            <textarea name="message" placeholder="Your Message" rows="5" required></textarea>
            <button type="submit">Send Message</button>
        </form>
    </section>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script type="text/javascript">
        let currentIndex = 0;
        const images = [
            'https://via.placeholder.com/1200x400?text=Ram%20Milan',
            'https://via.placeholder.com/1200x400?text=Tarun%20Sharma',
            'https://via.placeholder.com/1200x400?text=Sachin%20Verma'
        ];

        function changeBackground() {
            document.querySelector('.hero').style.backgroundImage = `url(${images[currentIndex]})`;
            currentIndex = (currentIndex + 1) % images.length;
        }
        setInterval(changeBackground, 3000);
        changeBackground();
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\laravel_techm\resources\views/frontend/home.blade.php ENDPATH**/ ?>
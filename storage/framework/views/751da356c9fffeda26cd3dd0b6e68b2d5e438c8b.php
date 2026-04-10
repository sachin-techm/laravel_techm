
<?php $__env->startSection('content'); ?>
<section class="hero-section d-flex align-items-center text-white">
    
    <div class="here-section-inner"></div>

    <div class="container text-center here-section-content-area">
        <h1 class="display-4 font-weight-bold">About Us</h1>
        <p class="lead mt-3">We build smart digital solutions for modern businesses</p>
    </div>
</section>

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
            </div>

        </div>
    </div>
</section>

<section class="vision-mission py-5">
    <div class="container">
        <div class="row">
            
            <div class="col-md-6">
                <div class="vm-box p-4 bg-light text-center" style="border-top: 5px solid #0598ce;">
                    <h3>Our Mission</h3>
                    <p>Our mission is to provide high-quality web development and digital marketing services that help our clients achieve their business goals. We understand what it takes to succeed in this industry and will put our expertise to work for you.</p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="vm-box p-4 bg-light text-center" style="border-top: 5px solid #0598ce;">
                    <h3>Our Vision</h3>
                    <p>Our vision is to be the leading provider of quality web development and digital marketing services in India, and to be recognized as a trusted partner by our clients.</p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- SECTION 3: CTA -->
<section class="cta-section">

    <div class="cta-section-inner"></div>

  <div class="container text-center cta-section-content-area">
    <h2>We are Here to Help You</h2>
    <p>If you’re looking for the best solutions to all your issues, we are here to help. We offer comprehensive IT solutions for all your needs, from web development to digital marketing and support. Our team of experienced professionals is dedicated to providing the best possible service, so you can rest assured that your problems will be solved quickly and efficiently.</p>
    <a href="/contact" class="btn-contact">Contact Us</a>
  </div>
</section>

<!-- SECTION 4: BLOG -->
<section class="blog-section">
  <div class="container">
    <h2 class="text-center">Latest Articles & Blog</h2>
    <p class="text-center">Get various articles and blog on multiple services here.</p>
    <div class="blog-grid">
      <div class="blog-card">
        <img src="<?php echo e(asset('assets/frontend/images/about-us.webp')); ?>" alt="blog">
        <h4>WordPress Development Company in Noida</h4>
        <p>WordPress Development Company in Noida for Reliable and Scalable Website Solutions In today’s digital environment, businesses need more than...</p>
        <a href="#">Read More</a>
      </div>
      <div class="blog-card">
        <img src="<?php echo e(asset('assets/frontend/images/about-us.webp')); ?>" alt="blog">
        <h4>SEO Company in Noida Sector 63</h4>
        <p>SEO Company in Noida Sector 63 for Strong and Consistent Digital Growth In today’s digital environment, businesses are constantly...</p>
        <a href="#">Read More</a>
      </div>
      <div class="blog-card">
        <img src="<?php echo e(asset('assets/frontend/images/about-us.webp')); ?>" alt="blog">
        <h4>Best Web Design Company in Noida</h4>
        <p>Choose the Best Web Design Company in Noida for Long-Term Business Growth In today’s fast-moving digital environment, businesses are...</p>
        <a href="#">Read More</a>
      </div>
    </div>
  </div>
</section>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script type="text/javascript">    

</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\laravel_techm\resources\views/frontend/about.blade.php ENDPATH**/ ?>
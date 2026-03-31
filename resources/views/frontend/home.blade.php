@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section class="hero">
        <div>
            <!-- <img src="{{asset('assets/frontend/images/RCLS_logo.png')}}" height="250px;"> -->
            <h1>Way Towards Innovative, Efficient & <br>Smart Digital Solutions</h1>
            <p>The 2024 Edition was a massive success and we now look forward to the 2025 Edition. <br/>In case of any interest, please get in touch with us.</p>
        </div>
    </section>

    <!-- Services Section -->
    <section class="services" id="services">
        <h2>Our Services</h2>
        <div class="service">
            <div class="service-item">
                <h3>Service 1</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
            </div>
            <div class="service-item">
                <h3>Service 2</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
            </div>
            <div class="service-item">
                <h3>Service 3</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
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

@endsection

@push('scripts')
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
@endpush

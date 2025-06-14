<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excel Genius - Student Management System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --accent: #4895ef;
            --light: #f8f9fa;
            --dark: #212529;
            --success: #4cc9f0;
            --warning: #f72585;
        }

        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
            color: var(--dark);
            background-color: #f5f7ff;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header Styles */
        header {
            background-color: white;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 0;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary);
        }

        .logo i {
            color: var(--secondary);
        }

        nav ul {
            display: flex;
            list-style: none;
            gap: 30px;
        }

        nav a {
            text-decoration: none;
            color: var(--dark);
            font-weight: 500;
            transition: color 0.3s;
            position: relative;
        }

        nav a:hover {
            color: var(--primary);
        }

        nav a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background-color: var(--primary);
            transition: width 0.3s;
        }

        nav a:hover::after {
            width: 100%;
        }

        .auth-buttons {
            display: flex;
            gap: 15px;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 50px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            border: none;
            font-size: 1rem;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--secondary);
            transform: translateY(-2px);
        }

        .btn-outline {
            background-color: transparent;
            border: 2px solid var(--primary);
            color: var(--primary);
        }

        .btn-outline:hover {
            background-color: var(--primary);
            color: white;
        }

        .mobile-menu {
            display: none;
            font-size: 1.5rem;
            cursor: pointer;
        }

        /* Hero Section */
        .hero {
            padding: 160px 0 100px;
            background: linear-gradient(135deg, #e0f7ff 0%, #f0f4ff 100%);
            position: relative;
            overflow: hidden;
        }

        .hero-content {
            display: flex;
            align-items: center;
            gap: 50px;
        }

        .hero-text {
            flex: 1;
            z-index: 2;
        }

        .hero-text h1 {
            font-size: 3.5rem;
            line-height: 1.2;
            margin-bottom: 20px;
            color: var(--secondary);
        }

        .hero-text p {
            font-size: 1.2rem;
            margin-bottom: 30px;
            color: #555;
            max-width: 600px;
        }

        .hero-image {
            flex: 1;
            position: relative;
            z-index: 1;
        }

        .hero-image img {
            max-width: 100%;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .features {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-top: 50px;
        }

        .feature-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-10px);
        }

        .feature-card i {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 15px;
        }

        .feature-card h3 {
            margin-bottom: 10px;
            color: var(--secondary);
        }

        /* Stats Section */
        .stats {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            padding: 80px 0;
            text-align: center;
        }

        .stats-container {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
        }

        .stat-item {
            padding: 20px;
        }

        .stat-item i {
            font-size: 2.5rem;
            margin-bottom: 15px;
        }

        .stat-item .number {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        /* Benefits Section */
        .benefits {
            padding: 100px 0;
        }

        .section-header {
            text-align: center;
            max-width: 800px;
            margin: 0 auto 60px;
        }

        .section-header h2 {
            font-size: 2.5rem;
            color: var(--secondary);
            margin-bottom: 20px;
        }

        .section-header p {
            color: #666;
            font-size: 1.1rem;
        }

        .benefits-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 40px;
            align-items: center;
        }

        .benefits-image img {
            max-width: 100%;
            border-radius: 20px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .benefits-list {
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        .benefit-item {
            display: flex;
            gap: 20px;
            padding: 20px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s;
        }

        .benefit-item:hover {
            transform: translateX(10px);
        }

        .benefit-icon {
            min-width: 60px;
            height: 60px;
            background: #eef4ff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: var(--primary);
        }

        /* Testimonials */
        .testimonials {
            padding: 100px 0;
            background: #f0f5ff;
        }

        .testimonial-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 30px;
        }

        .testimonial {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            position: relative;
            text-align: center;
        }

        .testimonial::before {
            content: '"';
            position: absolute;
            top: 20px;
            left: 30px;
            font-size: 5rem;
            color: #eef4ff;
            font-family: serif;
        }

        .testimonial-text {
            font-size: 1.2rem;
            font-style: italic;
            margin-bottom: 30px;
            color: #555;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }

        .author-image {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1.5rem;
        }

        .author-details h4 {
            color: var(--secondary);
        }

        .author-details p {
            color: #777;
        }

        /* CTA Section */
        .cta {
            padding: 100px 0;
            background: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%);
            color: white;
            text-align: center;
        }

        .cta h2 {
            font-size: 2.8rem;
            margin-bottom: 20px;
        }

        .cta p {
            max-width: 700px;
            margin: 0 auto 40px;
            font-size: 1.2rem;
            opacity: 0.9;
        }

        .cta-buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .btn-light {
            background: white;
            color: var(--primary);
            padding: 15px 35px;
            font-size: 1.1rem;
            font-weight: 600;
        }

        .btn-light:hover {
            background: #f0f0f0;
            transform: translateY(-3px);
        }

        .btn-transparent {
            background: transparent;
            border: 2px solid white;
            color: white;
            padding: 15px 35px;
            font-size: 1.1rem;
            font-weight: 600;
        }

        .btn-transparent:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        /* Footer */
        footer {
            background: var(--dark);
            color: white;
            padding: 80px 0 30px;
        }

        .footer-container {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 40px;
            margin-bottom: 60px;
        }

        .footer-column h3 {
            font-size: 1.3rem;
            margin-bottom: 25px;
            position: relative;
            padding-bottom: 10px;
        }

        .footer-column h3::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 2px;
            background: var(--accent);
        }

        .footer-column ul {
            list-style: none;
        }

        .footer-column ul li {
            margin-bottom: 15px;
        }

        .footer-column ul li a {
            color: #bbb;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-column ul li a:hover {
            color: white;
        }

        .social-links {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            color: white;
            transition: all 0.3s;
        }

        .social-links a:hover {
            background: var(--primary);
            transform: translateY(-3px);
        }

        .copyright {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: #bbb;
            font-size: 0.9rem;
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .features {
                grid-template-columns: repeat(2, 1fr);
            }

            .stats-container {
                grid-template-columns: repeat(2, 1fr);
            }

            .benefits-container {
                grid-template-columns: 1fr;
            }

            .footer-container {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            nav ul {
                display: none;
            }

            .mobile-menu {
                display: block;
            }

            .auth-buttons {
                display: none;
            }

            .hero-content {
                flex-direction: column;
            }

            .hero-text h1 {
                font-size: 2.5rem;
            }

            .features {
                grid-template-columns: 1fr;
            }

            .stats-container {
                grid-template-columns: 1fr;
            }

            .footer-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container header-container">
            <div class="logo">
                <i class="fas fa-graduation-cap"></i>
                <span>Excel Genius</span>
            </div>
            <nav>
                <ul>
                    <li><a href="#features">Features</a></li>
                    <li><a href="#benefits">Benefits</a></li>
                    <li><a href="#testimonials">Testimonials</a></li>
                    <li><a href="#pricing">Pricing</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </nav>
            <div class="auth-buttons">
                <button class="btn btn-outline">Login</button>
                <button class="btn btn-primary">Get Started</button>
            </div>
            <div class="mobile-menu">
                <i class="fas fa-bars"></i>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container hero-content">
            <div class="hero-text">
                <h1>Streamline Your School Management Effortlessly</h1>
                <p>EduTrack is a comprehensive student management system designed to simplify administrative tasks, improve communication, and enhance the educational experience for institutions of all sizes.</p>
                <div class="hero-buttons">
                    <button class="btn btn-primary">Start Free Trial</button>
                    <button class="btn btn-outline">Watch Demo</button>
                </div>
            </div>
            <div class="hero-image">
                <img src="https://images.unsplash.com/photo-1584697964358-3e14ca57658b?auto=format&fit=crop&w=800" alt="Student Management Dashboard">
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section" id="features">
        <div class="container">
            <div class="features">
                <div class="feature-card">
                    <i class="fas fa-user-friends"></i>
                    <h3>Student Profiles</h3>
                    <p>Comprehensive student records with academic history, attendance, and personal details.</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-calendar-alt"></i>
                    <h3>Attendance Tracking</h3>
                    <p>Automated attendance system with real-time reporting and notifications.</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-book"></i>
                    <h3>Grade Management</h3>
                    <p>Easily record, calculate, and distribute grades with customizable grading scales.</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-comments"></i>
                    <h3>Parent Portal</h3>
                    <p>Keep parents informed with real-time updates on student progress and events.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats">
        <div class="container stats-container">
            <div class="stat-item">
                <i class="fas fa-school"></i>
                <div class="number">1,200+</div>
                <div>Schools Trust EduTrack</div>
            </div>
            <div class="stat-item">
                <i class="fas fa-users"></i>
                <div class="number">750K+</div>
                <div>Active Students</div>
            </div>
            <div class="stat-item">
                <i class="fas fa-chart-line"></i>
                <div class="number">95%</div>
                <div>Improved Efficiency</div>
            </div>
            <div class="stat-item">
                <i class="fas fa-globe"></i>
                <div class="number">15+</div>
                <div>Countries Worldwide</div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section class="benefits" id="benefits">
        <div class="container">
            <div class="section-header">
                <h2>Transform Your Educational Institution</h2>
                <p>Discover how EduTrack can revolutionize your administrative processes and enhance the learning experience.</p>
            </div>
            <div class="benefits-container">
                <div class="benefits-image">
                    <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?auto=format&fit=crop&w=800" alt="Education Technology">
                </div>
                <div class="benefits-list">
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="benefit-content">
                            <h3>Save Time on Administration</h3>
                            <p>Automate routine tasks and free up staff for more important educational activities.</p>
                        </div>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-chart-pie"></i>
                        </div>
                        <div class="benefit-content">
                            <h3>Data-Driven Decisions</h3>
                            <p>Access comprehensive reports and analytics to make informed decisions.</p>
                        </div>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-comment-dots"></i>
                        </div>
                        <div class="benefit-content">
                            <h3>Enhanced Communication</h3>
                            <p>Connect teachers, students, and parents through our integrated platform.</p>
                        </div>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-lock"></i>
                        </div>
                        <div class="benefit-content">
                            <h3>Secure & Compliant</h3>
                            <p>Enterprise-grade security with compliance for educational data regulations.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials" id="testimonials">
        <div class="container">
            <div class="section-header">
                <h2>What Our Clients Say</h2>
                <p>Hear from educational institutions that have transformed their operations with EduTrack.</p>
            </div>
            <div class="testimonial-container">
                <div class="testimonial">
                    <p class="testimonial-text">"Since implementing EduTrack, our administrative workload has decreased by 40%. The system is intuitive, comprehensive, and has dramatically improved communication between teachers and parents."</p>
                    <div class="testimonial-author">
                        <div class="author-image">SD</div>
                        <div class="author-details">
                            <h4>Sarah Johnson</h4>
                            <p>Principal, Westfield Academy</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <div class="container">
            <h2>Ready to Transform Your School Management?</h2>
            <p>Join thousands of educational institutions that have revolutionized their administrative processes with EduTrack. Start your free trial today with no commitment.</p>
            <div class="cta-buttons">
                <button class="btn btn-light">Start Free 14-Day Trial</button>
                <button class="btn btn-transparent">Schedule a Demo</button>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-container">
                <div class="footer-column">
                    <div class="logo">
                        <i class="fas fa-graduation-cap"></i>
                        <span>EduTrack</span>
                    </div>
                    <p>Comprehensive student management system designed to streamline educational administration and enhance learning experiences.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="footer-column">
                    <h3>Features</h3>
                    <ul>
                        <li><a href="#">Student Information</a></li>
                        <li><a href="#">Attendance Tracking</a></li>
                        <li><a href="#">Grade Management</a></li>
                        <li><a href="#">Scheduling</a></li>
                        <li><a href="#">Parent Portal</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Company</h3>
                    <ul>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Careers</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">Press</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Support</h3>
                    <ul>
                        <li><a href="#">Help Center</a></li>
                        <li><a href="#">Documentation</a></li>
                        <li><a href="#">Community</a></li>
                        <li><a href="#">Webinars</a></li>
                        <li><a href="#">Status</a></li>
                    </ul>
                </div>
            </div>
            <div class="copyright">
                <p>&copy; 2025 . All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Simple smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>
</html>

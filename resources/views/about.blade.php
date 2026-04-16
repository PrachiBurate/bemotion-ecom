  @extends('layouts.app')

@section('content')
  <main class="main-bg">
            <!--====== Start Page Banner Section ======-->
            <section class="page-banner">
                <div class="page-banner-wrapper p-r z-1">
                    <svg class="lineanm" viewBox="0 0 1920 347" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path class="line" d="M-39 345.187C70 308.353 397.628 293.477 436 145.186C490 -63.5 572 -57.8156 688 255.186C757.071 441.559 989.5 -121.315 1389 98.6856C1708.6 274.686 1940.33 156.519 1964.5 98.6856" stroke="white" stroke-width="3" stroke-dasharray="2 2"/>
                    </svg>
                    <div class="page-image"><img src="assets/images/bg/page-img-1.png" alt="image"></div>
                    <svg class="page-svg" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21.1742 33.0065C14.029 35.2507 7.5486 39.0636 0 40.7339V86H1937V64.9942C1933.1 60.1623 1912.65 65.1777 1904.51 62.6581C1894.22 59.4678 1884.93 55.0079 1873.77 52.7742C1861.2 50.2585 1823.41 36.3854 1811.99 39.9252C1805.05 42.0727 1796.94 37.6189 1789.36 36.6007C1769.18 33.8879 1747.19 31.1848 1726.71 29.7718C1703.81 28.1919 1678.28 27.0012 1657.53 34.4442C1636.45 42.005 1606.07 60.856 1579.5 55.9191C1561.6 52.5906 1543.41 47.0959 1528.45 56.9075C1510.85 68.4592 1485.74 74.2518 1460.44 76.136C1432.32 78.2297 1408.53 70.6879 1384.73 62.2987C1339.52 46.361 1298.19 27.1677 1255.08 9.28534C1242.58 4.10111 1214.68 15.4762 1200.55 16.6533C1189.77 17.5509 1181.74 15.4508 1172.12 12.8795C1152.74 7.70033 1133.23 2.88525 1111.79 2.63621C1088.85 2.36971 1073.94 7.88289 1056.53 15.8446C1040.01 23.3996 1027.48 26.1777 1007.8 26.1777C993.757 26.1777 975.854 25.6887 962.844 28.9632C941.935 34.2258 932.059 38.7874 914.839 28.6037C901.654 20.8061 866.261 -2.56499 844.356 7.12886C831.264 12.9222 820.932 21.5146 807.663 27.5255C798.74 31.5679 779.299 42.0561 766.33 39.1166C758.156 37.2637 751.815 31.6349 745.591 28.2443C730.967 20.2774 715.218 13.2948 695.846 10.723C676.168 8.11038 658.554 23.1787 641.606 27.4357C617.564 33.4742 602.283 27.7951 579.244 27.7951C568.142 27.7951 548.414 30.4002 541.681 23.6618C535.297 17.2722 530.162 9.74921 523.263 3.71444C517.855 -1.01577 505.798 -0.852017 498.318 2.09709C479.032 9.7007 453.07 10.0516 431.025 9.64475C407.556 9.21163 368.679 1.61612 346.618 10.3636C319.648 21.0575 291.717 53.8338 254.67 45.2266C236.134 40.9201 225.134 37.5813 204.78 40.7339C186.008 43.6415 171.665 50.7785 156.051 57.3567C146.567 61.3523 152.335 52.6281 151.12 47.9222C149.535 41.7853 139.994 34.5585 132.991 30.4008C120.206 22.8098 90.2848 24.3246 74.2546 24.6502C55.5552 25.0301 37.9201 27.747 21.1742 33.0065Z" fill="#FFFAF3"/>
                    </svg>
                    <div class="shape shape-one"><span></span></div>
                    <div class="shape shape-two"><span></span></div>
                    <div class="shape shape-three"><span><img src="assets/images/shape/curved-arrow.png" alt=""></span></div>
                    <div class="shape shape-four"><span><img src="assets/images/shape/stars.png" alt=""></span></div>                
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="page-banner-content">
                                    <h1>About Us</h1>
                                    <ul class="breadcrumb-link">
                                        <li><a href="{{ url('/') }}">Home</a></li>
                                        <li><i class="far fa-long-arrow-right"></i></li>
                                        <li class="active">About Us</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section><!--====== End Page Banner Section ======-->
            <!--====== Start About Us Section ======-->
            <section class="about-us-section pt-120">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-6">
                            <!--====== Section Image Box ======-->
                            <div class="section-image-box style-one mb-50" data-aos="fade-up" data-aos-delay="30" data-aos-duration="1000">
                                <div class="image-one">
                                    <img src="assets/images/about/about-1.jpg" alt="About Image">
                                    <div class="img-shape"></div>
                                </div>
                                <div class="image-two">
                                    <img src="assets/images/about/about-2.jpg" alt="About Image">
                                    <span class="line"></span>
                                </div>
                                <div class="experience-box">
                                    <div class="icon">
                                        <img src="assets/images/about/star.svg" alt="Icon">
                                    </div>
                                    <div class="text">
                                        <div class="year">
                                            25
                                        </div>
                                        <div class="duration">
                                            Year’s <br> Experience
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <!--====== Section Content Box ======-->
                            <div class="section-content-box style-one" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1200">
                                <div class="section-title mb-30">
                                    <div class="sub-heading d-inline-flex align-items-center">
                                        <i class="flaticon-sparkler"></i>
                                        <span class="sub-title">About us</span>
                                    </div>
                                    <h2>Online shopping is buying things from stores on the internet.</h2>
                                </div>
                                <p>There are many variations of passages of Lorem Ipsum available, but the our majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable you are going to.</p>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <ul class="list mb-25">
                                            <li><i class="flaticon-star-3"></i> We are provide 100% best products</li>
                                            <li><i class="flaticon-star-3"></i>Flexible and affordable price</li>
                                            <li><i class="flaticon-star-3"></i>All products is imported</li>
                                        </ul>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="thumbnail-img mb-25">
                                                    <img src="assets/images/about/about-3.png" alt="thumbnail img">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="thumbnail-img mb-25">
                                                    <img src="assets/images/about/about-4.png" alt="thumbnail img">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="content-wrap-box d-flex mt-25">
                                    <div class="author-item">
                                        <div class="author-thumb">
                                            <img src="assets/images/testimonial/author-3.png" alt="author image">
                                        </div>
                                        <div class="author-info">
                                            <h5>Thomas Alison</h5>
                                            <span class="position">CEO at PESCO</span>
                                        </div>
                                    </div>
                                    <div class="divider">
                                        <img src="assets/images/about/divider.png" alt="divider">
                                    </div>
                                    <div class="signature">
                                        <img src="assets/images/about/signature.png" alt="divider">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section><!--====== End About Us Section ======-->
            <!--====== Start Features Section ======-->
            <section class="features-section pt-80">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <!--=== Features Wrapper ===-->
                            <div class="features-wrapper" data-aos="fade-up" data-aos-delay="70" data-aos-duration="1400">
                                <!--=== Iconic Box Item ===-->
                                <div class="iconic-box-item icon-left-box mb-25">
                                    <div class="icon">
                                        <i class="fas fa-shipping-fast"></i>
                                    </div>
                                    <div class="content">
                                        <h5>Free Shipping</h5>
                                        <p>You get your items delivered without any extra cost.</p>
                                    </div>
                                </div>
                                <!--=== Divider ===-->
                                <div class="divider mb-25">
                                    <img src="assets/images/divider.png" alt="divider">
                                </div>
                                <!--=== Iconic Box Item ===-->
                                <div class="iconic-box-item icon-left-box mb-25">
                                    <div class="icon">
                                        <i class="fas fa-microphone"></i>
                                    </div>
                                    <div class="content">
                                        <h5>Great Support 24/7</h5>
                                        <p>Our customer support team is available around the clock </p>
                                    </div>
                                </div>
                                <!--=== Divider ===-->
                                <div class="divider mb-25">
                                    <img src="assets/images/divider.png" alt="divider">
                                </div>
                                <!--=== Iconic Box Item ===-->
                                <div class="iconic-box-item icon-left-box mb-25">
                                    <div class="icon">
                                        <i class="far fa-handshake"></i>
                                    </div>
                                    <div class="content">
                                        <h5>Return Available</h5>
                                        <p>Making it easy to return any items if you're not satisfied.</p>
                                    </div>
                                </div>
                                <!--=== Divider ===-->
                                <div class="divider mb-25">
                                    <img src="assets/images/divider.png" alt="divider">
                                </div>
                                <!--=== Iconic Box Item ===-->
                                <div class="iconic-box-item icon-left-box mb-25">
                                    <div class="icon">
                                        <i class="fas fa-sack-dollar"></i>
                                    </div>
                                    <div class="content">
                                        <h5>Secure Payment</h5>
                                        <p>Shop with confidence knowing that our secure payment</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section><!--====== End Features Section ======-->
            <!--====== Start Team Section ======-->
            <section class="team-section pt-125 pb-60">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <!--=== Section Title  ===-->
                            <div class="section-title text-center mb-60" data-aos="fade-up" data-aos-delay="10" data-aos-duration="800">
                                <div class="sub-heading d-inline-flex align-items-center">
                                    <i class="flaticon-sparkler"></i>
                                    <span class="sub-title">Our Team</span>
                                    <i class="flaticon-sparkler"></i>
                                </div>
                                <h2>Meet Management Team</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="team-slider-one">
                    <div class="team-item style-one" data-aos="fade-up" data-aos-delay="15" data-aos-duration="600">
                        <div class="member-info">
                            <h5>Davis Liam </h5>
                            <span class="position">Marketing Specialist</span>
                        </div>
                        <div class="member-img">
                            <img src="assets/images/team/team-1.jpg" alt="Team Image">
                            <div class="hover-content">
                                <ul class="social-link">
                                    <li><a href="#"><i class="flaticon-facebook"></i></a></li>
                                    <li><a href="#"><i class="flaticon-linkedin"></i></a></li>
                                    <li><a href="#"><i class="flaticon-instagram"></i></a></li>
                                    <li><a href="#"><i class="flaticon-twitter"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="team-item style-one" data-aos="fade-up" data-aos-delay="20" data-aos-duration="800">
                        <div class="member-info">
                            <h5>Michael Davis</h5>
                            <span class="position">Digital Marketing Specialist</span>
                        </div>
                        <div class="member-img">
                            <img src="assets/images/team/team-2.jpg" alt="Team Image">
                            <div class="hover-content">
                                <ul class="social-link">
                                    <li><a href="#"><i class="flaticon-facebook"></i></a></li>
                                    <li><a href="#"><i class="flaticon-linkedin"></i></a></li>
                                    <li><a href="#"><i class="flaticon-instagram"></i></a></li>
                                    <li><a href="#"><i class="flaticon-twitter"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="team-item style-one" data-aos="fade-up" data-aos-delay="25" data-aos-duration="1000">
                        <div class="member-info">
                            <h5>Sarah Jones</h5>
                            <span class="position">Product Manager</span>
                        </div>
                        <div class="member-img">
                            <img src="assets/images/team/team-3.jpg" alt="Team Image">
                            <div class="hover-content">
                                <ul class="social-link">
                                    <li><a href="#"><i class="flaticon-facebook"></i></a></li>
                                    <li><a href="#"><i class="flaticon-linkedin"></i></a></li>
                                    <li><a href="#"><i class="flaticon-instagram"></i></a></li>
                                    <li><a href="#"><i class="flaticon-twitter"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="team-item style-one" data-aos="fade-up" data-aos-delay="30" data-aos-duration="1200">
                        <div class="member-info">
                            <h5>Emily Garcia</h5>
                            <span class="position">Digital Marketing Specialist</span>
                        </div>
                        <div class="member-img">
                            <img src="assets/images/team/team-4.jpg" alt="Team Image">
                            <div class="hover-content">
                                <ul class="social-link">
                                    <li><a href="#"><i class="flaticon-facebook"></i></a></li>
                                    <li><a href="#"><i class="flaticon-linkedin"></i></a></li>
                                    <li><a href="#"><i class="flaticon-instagram"></i></a></li>
                                    <li><a href="#"><i class="flaticon-twitter"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="team-item style-one" data-aos="fade-up" data-aos-delay="35" data-aos-duration="1400">
                        <div class="member-info">
                            <h5>Olivia Michael</h5>
                            <span class="position">Service Representative</span>
                        </div>
                        <div class="member-img">
                            <img src="assets/images/team/team-5.jpg" alt="Team Image">
                            <div class="hover-content">
                                <ul class="social-link">
                                    <li><a href="#"><i class="flaticon-facebook"></i></a></li>
                                    <li><a href="#"><i class="flaticon-linkedin"></i></a></li>
                                    <li><a href="#"><i class="flaticon-instagram"></i></a></li>
                                    <li><a href="#"><i class="flaticon-twitter"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="team-item style-one" data-aos="fade-up" data-aos-delay="40" data-aos-duration="1600">
                        <div class="member-info">
                            <h5>Davidthy Phillips</h5>
                            <span class="position">Senior Developer</span>
                        </div>
                        <div class="member-img">
                            <img src="assets/images/team/team-6.jpg" alt="Team Image">
                            <div class="hover-content">
                                <ul class="social-link">
                                    <li><a href="#"><i class="flaticon-facebook"></i></a></li>
                                    <li><a href="#"><i class="flaticon-linkedin"></i></a></li>
                                    <li><a href="#"><i class="flaticon-instagram"></i></a></li>
                                    <li><a href="#"><i class="flaticon-twitter"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="team-item style-one" data-aos="fade-up" data-aos-delay="45" data-aos-duration="1700">
                        <div class="member-info">
                            <h5>Sarah Jones</h5>
                            <span class="position">Product Manager</span>
                        </div>
                        <div class="member-img">
                            <img src="assets/images/team/team-3.jpg" alt="Team Image">
                            <div class="hover-content">
                                <ul class="social-link">
                                    <li><a href="#"><i class="flaticon-facebook"></i></a></li>
                                    <li><a href="#"><i class="flaticon-linkedin"></i></a></li>
                                    <li><a href="#"><i class="flaticon-instagram"></i></a></li>
                                    <li><a href="#"><i class="flaticon-twitter"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="team-dots-arrows d-flex align-items-center justify-content-between">
                        <div class="team-slider-dots mt-25"></div>
                        <div class="team-arrows style-one mt-25"></div>
                    </div>
                </div>
            </section>
            <!--====== End Team Section ======-->
            <!--====== Start Testimonial Section ======-->
            <section class="testimonial-section">
                <div class="testimonial-wrapper overflow-x-hidden pt-190 pb-90 white-bg">
                    <div class="shape svg-shape1"><img src="assets/images/testimonial/tl-svgTop.svg" alt="svg shape"></div>
                    <div class="shape svg-shape2"><img src="assets/images/testimonial/tl-svgBottom.svg" alt="svg shape"></div>
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-4">
                                <!--=== Section Content Box ===-->
                                <div class="section-content-box mb-40" data-aos="fade-right" data-aos-delay="30" data-aos-duration="800">
                                    <div class="section-title mb-50">
                                        <h2>What Our Clients Say About Us</h2>
                                    </div>
                                    <div class="testimonial-arrows style-one justif"></div>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <!--=== Testimonial Slider ===-->
                                <div class="testimonial-slider-one" data-aos="fade-left" data-aos-delay="50" data-aos-duration="1000">
                                    <!--=== Testimonial Item ===-->
                                    <div class="testimonial-item style-one mb-40">
                                        <div class="testimonial-content">
                                            <p>This inflatable dragon costume seemed perfect for Halloween! But upon inflating, it became clear the wings were uneven, causing me to spin uncontrollably like a rogue pool float. </p>
                                            <div class="author-quote-item d-flex justify-content-between align-items-center">
                                                <div class="author-item">
                                                    <div class="author-thumb">
                                                        <img src="assets/images/testimonial/author-1.png" alt="author image">
                                                    </div>
                                                    <div class="author-info">
                                                        <h5>Rhodes Jhon</h5>
                                                        <ul class="ratings rating5">
                                                            <li><i class="fas fa-star"></i></li>
                                                            <li><i class="fas fa-star"></i></li>
                                                            <li><i class="fas fa-star"></i></li>
                                                            <li><i class="fas fa-star"></i></li>
                                                            <li><i class="fas fa-star"></i></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="quote-icon">
                                                    <i class="flaticon flaticon-right-quote"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--=== Testimonial Item ===-->
                                    <div class="testimonial-item style-one mb-40">
                                        <div class="testimonial-content">
                                            <p>This inflatable dragon costume seemed perfect for Halloween! But upon inflating, it became clear the wings were uneven, causing me to spin uncontrollably like a rogue pool float. </p>
                                            <div class="author-quote-item d-flex justify-content-between align-items-center">
                                                <div class="author-item">
                                                    <div class="author-thumb">
                                                        <img src="assets/images/testimonial/author-2.png" alt="author image">
                                                    </div>
                                                    <div class="author-info">
                                                        <h5>Rhodes Jhon</h5>
                                                        <ul class="ratings rating5">
                                                            <li><i class="fas fa-star"></i></li>
                                                            <li><i class="fas fa-star"></i></li>
                                                            <li><i class="fas fa-star"></i></li>
                                                            <li><i class="fas fa-star"></i></li>
                                                            <li><i class="fas fa-star"></i></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="quote-icon">
                                                    <i class="flaticon flaticon-right-quote"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--=== Testimonial Item ===-->
                                    <div class="testimonial-item style-one mb-40">
                                        <div class="testimonial-content">
                                            <p>This inflatable dragon costume seemed perfect for Halloween! But upon inflating, it became clear the wings were uneven, causing me to spin uncontrollably like a rogue pool float. </p>
                                            <div class="author-quote-item d-flex justify-content-between align-items-center">
                                                <div class="author-item">
                                                    <div class="author-thumb">
                                                        <img src="assets/images/testimonial/author-1.png" alt="author image">
                                                    </div>
                                                    <div class="author-info">
                                                        <h5>Rhodes Jhon</h5>
                                                        <ul class="ratings rating5">
                                                            <li><i class="fas fa-star"></i></li>
                                                            <li><i class="fas fa-star"></i></li>
                                                            <li><i class="fas fa-star"></i></li>
                                                            <li><i class="fas fa-star"></i></li>
                                                            <li><i class="fas fa-star"></i></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="quote-icon">
                                                    <i class="flaticon flaticon-right-quote"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--=== Testimonial Item ===-->
                                    <div class="testimonial-item style-one mb-40">
                                        <div class="testimonial-content">
                                            <p>This inflatable dragon costume seemed perfect for Halloween! But upon inflating, it became clear the wings were uneven, causing me to spin uncontrollably like a rogue pool float. </p>
                                            <div class="author-quote-item d-flex justify-content-between align-items-center">
                                                <div class="author-item">
                                                    <div class="author-thumb">
                                                        <img src="assets/images/testimonial/author-2.png" alt="author image">
                                                    </div>
                                                    <div class="author-info">
                                                        <h5>Rhodes Jhon</h5>
                                                        <ul class="ratings rating5">
                                                            <li><i class="fas fa-star"></i></li>
                                                            <li><i class="fas fa-star"></i></li>
                                                            <li><i class="fas fa-star"></i></li>
                                                            <li><i class="fas fa-star"></i></li>
                                                            <li><i class="fas fa-star"></i></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="quote-icon">
                                                    <i class="flaticon flaticon-right-quote"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section><!--====== End Working Section  ======-->
            <!--====== Start Working Section  ======-->
            <section class="work-processing-section pt-60 pb-80">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <!--=== Section Title  ===-->
                            <div class="section-title text-center mb-60" data-aos="fade-up" data-aos-delay="30" data-aos-duration="800">
                                <div class="sub-heading d-inline-flex align-items-center">
                                    <i class="flaticon-sparkler"></i>
                                    <span class="sub-title">Work Processing</span>
                                    <i class="flaticon-sparkler"></i>
                                </div>
                                <h2>How it Work processing</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-3 col-sm-6">
                            <!--=== Iconic Box Item  ===-->
                            <div class="iconic-box-item style-two mb-40" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">
                                <div class="sn-number">01</div>
                                <div class="icon">
                                    <i class="flaticon-searching"></i>
                                </div>
                                <div class="content">
                                    <h6>Browsing & Choosing</h6>
                                    <p>This is where customers visit your online store, browse your products.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6">
                            <!--=== Iconic Box Item  ===-->
                            <div class="iconic-box-item style-two mb-40" data-aos="fade-up" data-aos-delay="70" data-aos-duration="1200">
                                <div class="sn-number">02</div>
                                <div class="icon">
                                    <i class="flaticon-payment-method"></i>
                                </div>
                                <div class="content">
                                    <h6>Checkout & Payment</h6>
                                    <p>Once they have picked their items, customers proceed to checkout.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6">
                            <!--=== Iconic Box Item  ===-->
                            <div class="iconic-box-item style-two mb-40" data-aos="fade-up" data-aos-delay="90" data-aos-duration="1400">
                                <div class="sn-number">03</div>
                                <div class="icon">
                                    <i class="flaticon-currency"></i>
                                </div>
                                <div class="content">
                                    <h6>Order Fulfillment</h6>
                                    <p>After the order is placed, it's sent to your fulfillment team.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6">
                            <!--=== Iconic Box Item  ===-->
                            <div class="iconic-box-item style-two mb-40" data-aos="fade-up" data-aos-delay="110" data-aos-duration="1600">
                                <div class="sn-number">04</div>
                                <div class="icon">
                                    <i class="flaticon-delivery"></i>
                                </div>
                                <div class="content">
                                    <h6>Delivery to Customer</h6>
                                    <p>The packed order is then sent off with a shipping carrier</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section><!--====== End Working Section  ======-->
            <!--====== Start Newsletter Sections  ======-->
            <section class="newsletter-section pb-95">
                <div class="container">
                    <!--=== Newsletter Wrapper  ===-->
                    <div class="newsletter-wrapper white-bg p-r z-1" data-aos="fade-up" data-aos-duration="1000">
                        <div class="newsletter-shape pattern-one"><span><img src="assets/images/newsletter/pattern-1.png" alt="Pattern Shape"></span></div>
                        <div class="newsletter-shape pattern-two"><span><img src="assets/images/newsletter/pattern-2.png" alt="Pattern Shape"></span></div>
                        <div class="newsletter-shape shape-one"><span><img src="assets/images/newsletter/shape-1.png" alt="Shape"></span></div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="newsletter-content-box">
                                    <span class="sub-text">Our Newsletter</span>
                                    <h3>Get weekly update. Sign up and get up to <span>20% off</span> your first purchase</h3>
                                    <form>
                                        <div class="form-group">
                                            <input type="email" class="form_control" placeholder="Write your Email Address" name="email">
                                            <button class="theme-btn style-one">Subscribe</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="newsletter-image">
                                    <img src="assets/images/newsletter/newsletter-1.png" alt="Image">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section><!--====== End Newsletter Sections  ======-->
        </main>

        @endsection
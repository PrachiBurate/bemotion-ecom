<footer class="footer-main">
    <!--=== Footer Bg Wrapper  ===-->
    <div class="footer-bg-wrapper gray-bg">
       

        <!--=== Footer Widget Area  ===-->
        <div class="footer-widget-area pb-80">
            <div class="container">
                <div class="row">

                    <div class="col-xl-3 col-sm-6">
                        <!--=== Footer Widget  ===-->
                        <div class="footer-widget about-company-widget mb-40" data-aos="fade-up" data-aos-delay="10" data-aos-duration="1000">
                            <div class="widget-content">
                                <a href="{{ url('/') }}" class="footer-logo">
                                    <img src="{{ asset('assets/images/logo/'.$setting->logo) }}" style="width: 80px; height:80px;" alt="Logo">
                                </a>

                                <p>{{ $setting->slogan }}</p>

                                <ul class="ct-info-list mb-30">
                                    <li class="d-flex align-items-center flex-wrap gap-2">
                                        <i class="fas fa-envelope"></i>
                                        <a href="mailto:{{ $setting->email }}">
                                            {{ $setting->email }}
                                        </a>
                                        <span>|</span>
                                        <i class="fas fa-phone"></i>
                                        <a href="tel:{{ $setting->contact_number }}">
                                            {{ $setting->contact_number }}
                                        </a>
                                    </li>
                                </ul>

                                <ul class="social-link">
                                    <li><span>Find Us:</span></li>

                                    @if($setting->facebook_url)
                                    <li><a href="{{ $setting->facebook_url }}" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                                    @endif

                                    @if($setting->instagram_url)
                                    <li><a href="{{ $setting->instagram_url }}" target="_blank"><i class="fab fa-instagram"></i></a></li>
                                    @endif

                                    @if($setting->linkedin_url)
                                    <li><a href="{{ $setting->linkedin_url }}" target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
                                    @endif

                                    @if($setting->twitter_url)
                                    <li><a href="{{ $setting->twitter_url }}" target="_blank"><i class="fab fa-twitter"></i></a></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>

                      <div class="col-xl-3 col-md-6 col-sm-6">
                        <!--=== Footer Widget ===-->
                        <div class="footer-widget footer-nav-widget mb-40" data-aos="fade-up" data-aos-delay="20" data-aos-duration="1400">
                            <div class="widget-content">
                                <h4 class="widget-title">Quick Links</h4>
                                <ul class="widget-menu">
                                    <li><a href="{{ url('/') }}">Home</a></li>
                                    <li><a href="{{ url('/shops') }}">Shop</a></li>
                                    <li><a href="{{ url('/blog') }}">Blog</a></li>
                                    <li><a href="{{ url('/about') }}">About Us</a></li>
                                    <li><a href="{{ url('/faq') }}">FAQ</a></li>
                                    <li><a href="{{ url('/contact') }}">Contact</a></li>
                                    <li><a href="{{ url('/bulk-order') }}">Bulk Order</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 col-sm-6">
                        <!--=== Footer Widget ===-->
                        <div class="footer-widget footer-nav-widget mb-40" data-aos="fade-up" data-aos-delay="15" data-aos-duration="1200">
                            <div class="widget-content">
                                <h4 class="widget-title">Legal</h4>
                                <ul class="widget-menu">
                                    <li><a href="{{ url('/privacy-policy') }}">Privacy Policy</a></li>
                                    <li><a href="{{ url('/terms') }}">Terms &amp; Conditions</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                  

                    <!-- <div class="col-xl-3 col-sm-6">
                      
                        <div class="footer-widget footer-recent-post-widget" data-aos="fade-up" data-aos-delay="25" data-aos-duration="1600">

                            <h4 class="widget-title">Recent Post</h4>

                            <div class="widget-content">

                                @foreach($footerBlogs as $b)
                                <div class="recent-post-item">

                                   
                                    <div class="thumb">
                                        <img src="{{ asset('assets/images/blog/'.$b->image) }}" alt="post">
                                    </div>

                                    {{-- CONTENT --}}
                                    <div class="content">
                                        <h4>
                                            <a href="{{ url('/blog/'.$b->slug) }}">
                                                {{ $b->title }}
                                            </a>
                                        </h4>
                                        <span>
                                            <a href="{{ url('/blog/'.$b->slug) }}">
                                                {{ \Carbon\Carbon::parse($b->created_at)->format('M d, Y') }}
                                            </a>
                                        </span>
                                    </div>

                                </div>
                                @endforeach

                            </div>

                        </div>
                    </div> -->

                </div>
            </div>
        </div>

        <!--=== Footer Copyright  ===-->
        <div class="copyright-area">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="copyright-text">
                            <p>&copy; {{ date('Y') }}. All rights reserved by <span>{{ $setting->site_name }}</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
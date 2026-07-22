     @extends('layouts.app')

@section('content')
   <main class="main-bg">
            <!--====== Start Page Banner  ======-->
            <section class="page-banner">
                <!--===  Page Banner Wrapper  ===-->
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
                                <!--===  Page Banner Content  ===-->
                                <div class="page-banner-content">
                                    <h1>Blogs Details</h1>
                                    <ul class="breadcrumb-link">
                                        <li><a href="{{ url('/') }}">Home</a></li>
                                        <li><i class="far fa-long-arrow-right"></i></li>
                                        <li class="active">Blogs Details</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section><!--====== End Page Banner  ======-->
            <!--====== Start Blog Details Section  ======-->
            <section class="blog-details-section pt-120 pb-60">
                <div class="container">
                    <!--=== Blog Details Wrapper ===-->
                    <div class="blog-details-wrapper">
                        <div class="row">
                            <div class="col-xl-8">
                                <!--=== Blog Details Content ===-->
                                <div class="blog-details-content">
                                    <div class="blog-post-item mb-60">
                                        <div class="post-content" data-aos="fade-up" data-aos-delay="10" data-aos-duration="1000">
                                            <h3 class="title">10 easy ways to increase customers on your shopify store and increase more sells</h3>
                                            <div class="post-meta">
                                                <span><a href="#"><i class="far fa-user"></i>By Admin</a></span>
                                                <span><a href="#"><i class="far fa-calendar-alt"></i>12 Apr 2024</a></span>
                                                <span><a href="#"><i class="far fa-comment"></i>45 Comments</a></span>
                                            </div>
                                            <p>Growing your Shopify store requires a two-pronged approach: attracting more customers and converting them into loyal buyers. This blog post dives into 10 easy-to-implement strategies that will help you achieve both. First impressions matter!  Ensure your Shopify store has a clean, user-friendly design that showcases your products beautifully.</p>
                                            <figure><img src="assets/images/blog/blog-single-1.jpg" alt="Post Thumbnail"></figure>
                                            <p>Create valuable content that informs, educates, and entertains your target audience. This could be blog posts, infographics, videos, or even social media content.  By establishing yourself as a thought leader, you'll attract potential customers who are genuinely interested in what you offer.</p>
                                            <p>Embrace Social Media Marketing Social media platforms are a fantastic way to connect with potential customers and build brand awareness.  Share engaging content, run contests and giveaways, and interact with your followers to build a community around your brand.</p>
                                            <ul>
                                                <li><i class="flaticon-star-3"></i>Unleash the Potential of Email Marketing</li>
                                                <li><i class="flaticon-star-3"></i>Optimize for Search Engines (SEO)g</li>
                                                <li><i class="flaticon-star-3"></i>Offer Incentives and Discounts</li>
                                            </ul>
                                            <p>Implement search engine optimization (SEO) best practices to improve your store's ranking in search results. This involves keyword research, optimizing product titles and descriptions, and building backlinks to your store. Strategic use of promotions and discounts can entice customers to purchase.</p>
                                            <p>Provide exceptional customer service to build trust and loyalty.  Respond promptly to inquiries, offer hassle-free returns, and go the extra mile to ensure customer satisfaction.</p>
                                            <blockquote class="blockquote mb-40">
                                                <h4>But the load will be too heavy for us if we the a carry yesterday’s burden over again today</h4>
                                                <span class="cite">Tomas Alison</span>
                                                <div class="quote"><i class="flaticon-right-quote"></i></div>
                                            </blockquote>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <figure data-aos="fade-up" data-aos-delay="10" data-aos-duration="1000">
                                                        <img src="assets/images/blog/blog-single-2.jpg" alt="Post Thumbnail">
                                                    </figure>
                                                </div>
                                                <div class="col-md-6">
                                                    <figure data-aos="fade-up" data-aos-delay="10" data-aos-duration="1000">
                                                        <img src="assets/images/blog/blog-single-3.jpg" alt="Post Thumbnail">
                                                    </figure>
                                                </div>
                                            </div>
                                            <p>Positive customer reviews and testimonials act as social proof, convincing potential buyers to trust your brand.  Encourage satisfied customers to leave reviews and showcase them prominently on your store. A well-structured loyalty program incentivizes repeat purchases.  Offer points, discounts, or exclusive rewards</p>
                                        </div>
                                        <div class="entry-footer">
                                            <div class="tag-links">
                                                <span>Tag:</span>
                                                <a href="#">fashion</a>
                                                <a href="#">man</a>
                                                <a href="#">woman</a>
                                            </div>
                                            <div class="social-share">
                                                <span>share:</span>
                                                <a href="#"><i class="fab fa-facebook-f"></i></a>
                                                <a href="#"><i class="fab fa-instagram"></i></a>
                                                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                                <a href="#"><i class="fab fa-twitter"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <!--=== Post Navigation ===-->
                                    <div class="post-navigation mb-80" data-aos="fade-up" data-aos-delay="20" data-aos-duration="800">
                                        <div class="post-nav-item prev-post">
                                            <div class="thumb">
                                                <img src="assets/images/blog/post-thumb-4.jpg" alt="Thumbnail">
                                            </div>
                                            <div class="content">
                                                <a href="#" class="post-link"><i class="far fa-arrow-left"></i>Prev Post</a>
                                                <h6><a href="{{ url('/blog-details')}}">3 Unexpected Hacks to Unleash Your Hidden Creativity.</a></h6>
                                            </div>
                                        </div>
                                        <div class="post-nav-item next-post item-rtl">
                                            <div class="thumb">
                                                <img src="assets/images/blog/post-thumb-4.jpg" alt="Thumbnail">
                                            </div>
                                            <div class="content">
                                                <a href="#" class="post-link"><i class="far fa-arrow-right"></i>Next Post</a>
                                                <h6><a href="{{ url('/blog-details')}}">Do Delevery? You're Not Alone! Here's How to Fix It Fast</a></h6>
                                            </div>
                                        </div>
                                    </div>
                                    <!--=== Reviews Area ===-->
                                    <div class="pesco-comment-area mb-40" data-aos="fade-up" data-aos-delay="30" data-aos-duration="1000">
                                        <h4 class="mb-40">Total Reviews (90)</h4>
                                        <ul>
                                            <li class="comment">
                                                <div class="pesco-reviews-item">
                                                    <div class="author-thumb-info">
                                                        <div class="author-thumb">
                                                            <img src="assets/images/products/review-1.jpg" alt="Auhthor">
                                                        </div>
                                                        <div class="author-info">
                                                            <h5>Amelia Rodriguez</h5>
                                                            <div class="author-meta">
                                                                <span>20 March 2024</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="author-review-content">
                                                        <p>Men’s Slim Fit Dress Shirt is an excellent choice for those who value modern style and impeccable tailoring. Crafted from a high-quality blend of cotton and polyester, this shirt offers a smooth, wrinkle-resistant finish that stays crisp throughout the day.</p>
                                                    </div>
                                                    <a href="#" class="reply"><i class="fas fa-reply-all"></i>Reply</a>
                                                </div>
                                            </li>
                                            <li class="comment">
                                                <div class="pesco-reviews-item">
                                                    <div class="author-thumb-info">
                                                        <div class="author-thumb">
                                                            <img src="assets/images/products/review-2.jpg" alt="Auhthor">
                                                        </div>
                                                        <div class="author-info">
                                                            <h5>Amelia Rodriguez</h5>
                                                            <div class="author-meta">
                                                                <span>20 March 2024</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="author-review-content">
                                                        <p>Men’s Slim Fit Dress Shirt is an excellent choice for those who value modern style and impeccable tailoring. Crafted from a high-quality blend of cotton and polyester, this shirt offers a smooth, wrinkle-resistant finish that stays crisp throughout the day.</p>
                                                    </div>
                                                    <a href="#" class="reply"><i class="fas fa-reply-all"></i>Reply</a>
                                                </div>
                                                <ul class="comment-reply">
                                                    <li class="comment">
                                                        <div class="pesco-reviews-item">
                                                            <div class="author-thumb-info">
                                                                <div class="author-thumb">
                                                                    <img src="assets/images/products/review-3.jpg" alt="Auhthor">
                                                                </div>
                                                                <div class="author-info">
                                                                    <h5>Amelia Rodriguez</h5>
                                                                    <div class="author-meta">
                                                                        <span>20 March 2024</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="author-review-content">
                                                                <p>Men’s Slim Fit Dress Shirt is an excellent choice for those who value modern style and impeccable tailoring. Crafted from a high-quality blend of cotton and polyester, this shirt offers a smooth, wrinkle-resistant finish that stays crisp throughout the day.</p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                    <!--=== Contact Form ===-->
                                    <div class="pesco-contact-area mb-50" data-aos="fade-up" data-aos-delay="30" data-aos-duration="1200">
                                        <h4>Write Comment</h4>
                                        <ul class="ratings rating5 mb-40">
                                            <li><i class="fas fa-star"></i></li>
                                            <li><i class="fas fa-star"></i></li>
                                            <li><i class="fas fa-star"></i></li>
                                            <li><i class="fas fa-star"></i></li>
                                            <li><i class="fas fa-star"></i></li>
                                            <li><a href="#">(10)</a></li>
                                        </ul>
                                        <form class="pesco-contact-form">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <input type="text" placeholder="Name" class="form_control" name="name" required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <input type="email" placeholder="Email" class="form_control" name="Email" required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <textarea class="form_control" placeholder="Write Comment" name="message" cols="5" rows="8"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form_group">
                                                        <button class="theme-btn style-one">Submit Review</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <!--=== Sidebar Widget Area ===-->
                                <div class="sidebar-widget-area mb-50">
                                    <!--=== Sidebar Widget ===-->
                                    <div class="sidebar-widget sidebar-search-widget mb-50" data-aos="fade-up" data-aos-delay="20" data-aos-duration="1000">
                                        <h4 class="widget-title">Search</h4>
                                        <div class="widget-content">
                                            <p>isn't as anything embarrassing hidden in the middle of text.</p>
                                            <form>
                                                <input type="search" class="form_control" placeholder="Search" required>
                                            </form>
                                        </div>
                                    </div>
                                    <!--=== Sidebar Widget ===-->
                                    <div class="sidebar-widget sidebar-category-widget mb-50" data-aos="fade-up" data-aos-delay="40" data-aos-duration="1200">
                                        <h4 class="widget-title">Categories</h4>
                                        <div class="widget-content">
                                            <ul class="widget-nav">
                                                <li><a href="#">Fashion <i class="far fa-arrow-right"></i></a></li>
                                                <li><a href="#">Casual <i class="far fa-arrow-right"></i></a></li>
                                                <li><a href="#">Life Style <i class="far fa-arrow-right"></i></a></li>
                                                <li><a href="#">Kids Toy <i class="far fa-arrow-right"></i></a></li>
                                                <li><a href="#">Products <i class="far fa-arrow-right"></i></a></li>
                                                <li><a href="#">Women <i class="far fa-arrow-right"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <!--=== Sidebar Widget ===-->
                                    <div class="sidebar-widget sidebar-category-widget mb-40" data-aos="fade-up" data-aos-delay="60" data-aos-duration="1400">
                                        <h4 class="widget-title">Recent Posts</h4>
                                        <div class="widget-content">
                                            <ul class="recent-post-list">
                                                <li class="post-thumbnail-content">
                                                    <img src="assets/images/blog/post-thumb-1.jpg" alt="post thumb">
                                                    <div class="post-title-date">
                                                        <h6><a href="{{ url('/blog-details')}}">Tips on Finding Affordable Fashion Gems Online</a></h6>
                                                            <span class="posted-on"><a href="#">May 10, 2024</a></span>
                                                    </div>
                                                </li>
                                                <li class="post-thumbnail-content">
                                                    <img src="assets/images/blog/post-thumb-2.jpg" alt="post thumb">
                                                    <div class="post-title-date">
                                                        <h6><a href="{{ url('/blog-details')}}">Mastering the Art of Fashion E-commerce Marketing</a></h6>
                                                            <span class="posted-on"><a href="#">June 15, 2024</a></span>
                                                    </div>
                                                </li>
                                                <li class="post-thumbnail-content">
                                                    <img src="assets/images/blog/post-thumb-3.jpg" alt="post thumb">
                                                    <div class="post-title-date">
                                                        <h6><a href="{{ url('/blog-details')}}">Must-Have Trends You Can Shop Online Now</a></h6>
                                                        <span class="posted-on"><a href="#">July 24, 2024</a></span>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <!--===  Sidebar Widget  ===-->
                                    <div class="sidebar-widget sidebar-tag-widget mb-40" data-aos="fade-up" data-aos-delay="80" data-aos-duration="1600">
                                        <h4 class="widget-title">Tags</h4>
                                        <div class="widget-content">
                                            <div class="tagcloud">
                                                <a href="#">Accessories</a>
                                                <a href="#">Beauty</a>
                                                <a href="#">Casual</a>
                                                <a href="#">Fashion</a>
                                                <a href="#">Product</a>
                                                <a href="#">e-commerce</a>
                                                <a href="#">Modern Meal</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!--=== Sidebar Widget ===-->
                                    <div class="sidebar-newsletter-widget mb-40" data-aos="fade-up" data-aos-delay="100" data-aos-duration="1800">
                                        <div class="newsletter-content">
                                            <h5>Our Newsletter</h5>
                                            <p>Follow our newsletter to stay updated about us.</p>
                                            <form>
                                                <input type="text" class="form_control" placeholder="Enter Email Address" name="name" required>
                                                <button class="theme-btn style-one">Subscribe</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section><!--====== End Blog Details Section  ======-->
        </main>

              @endsection
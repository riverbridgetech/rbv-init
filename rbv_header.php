        <!-- Site Header -->

        <header class="site-header">
            <div class="container">
                <div class="site-logo">
                    <a href="index.php" class="default-logo"><img src="images/rbv-logo-white.png" alt="Logo"></a>
                    <a href="index.php" class="default-retina-logo"><img src="images/rbv-logo-white%402x.png" alt="Logo" width="199" height="30"></a>
                    <a href="index.php" class="sticky-logo"><img src="images/rbv-logo-black.png" alt="Logo"></a>
                    <a href="index.php" class="sticky-retina-logo"><img src="images/rbv-logo-black%402x.png" alt="Logo" width="199" height="30"></a>
                </div>
             	<a href="#" class="visible-sm visible-xs" id="menu-toggle"><i class="fa fa-bars"></i></a>
                <div class="header-info-col">
                    <?php
                    if(!isset($_SESSION['rbv_init_user']))
                    {
                        ?>
                        <a href="#" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#LoginModal">Login</a>    
                        <?php
                    }
                    else
                    {
                        ?>
                        <a href="<?php echo BASE_FOLDER.'logout.php'; ?>" class="btn btn-primary btn-lg">Logout</a>
                        <span>Welcome, <?php echo ucwords($_SESSION['rbv_init_user']['user_first_name'].' '.$_SESSION['rbv_init_user']['user_last_name']); ?></span>
                        <?php
                    }
                    ?>
                    
                </div>
                <ul class="sf-menu dd-menu pull-right" role="menu">
                    <?php
                        if($page_name == 'dashboard.php')
                        {
                            ?>
                            <li><a href="#section-home" class="page-scroll">Home</a>
                                    <!-- <ul>
                                        <li><a href="index2.html">Home version 2</a></li>
                                        <li><a href="index3.html">Home version 3</a></li>
                                        <li><a href="index-2.html">Header Styles</a>
                                            <ul>
                                                <li><a href="index-2.html">Style 1 (Default)</a></li>
                                                <li><a href="header-style2.html">Style 2</a></li>
                                                <li><a href="header-style3.html">Style 3</a></li>
                                            </ul>
                                        </li>
                                    </ul> -->
                                </li>                            
                            <?php
                        }
                        else
                        {
                            ?>
                            <li><a href="#section-about" class="page-scroll">About</a>
                                <!-- <ul>
                                    <li><a href="about.html">Introduction</a></li>
                                    <li><a href="team.html">Team</a></li>
                                    <li><a href="our-impact.html">Our Impact</a></li>
                                    <li><a href="careers.html">Careers</a></li>
                                    <li><a href="contact.html">Contact</a></li>
                                </ul> -->
                            </li>
                            <li><a href="#section-initiatives" class="page-scroll">Initiatives</a>
                                <ul>
                                    <li><a href="#section-education" class="page-scroll">Learning</a></li>
                                    <li><a href="#section-skill" class="page-scroll">Productivity</a></li>
                                    <li><a href="#section-wellness" class="page-scroll">Wellness</a></li>
                                </ul>
                            </li>
                            <li><a href="#section-team" class="page-scroll">Innovations Partner</a>
                                <!-- <ul>
                                    <li><a href="events.html">Events List</a></li>
                                    <li><a href="events-grid.html">Events Grid</a></li>
                                    <li><a href="events-calendar.html">Events Calendar</a></li>
                                    <li><a href="single-event.html">Single Event</a></li>
                                </ul> -->
                            </li>
                            <li><a href="#section-contact" class="page-scroll">Contact</a>
                                <!-- <ul>
                                    <li><a href="gallery-caption-2cols.html">Gallery with Caption</a>
                                        <ul>
                                            <li><a href="gallery-caption-2cols.html">2 Columns</a></li>
                                            <li><a href="gallery-caption-3cols.html">3 Columns</a></li>
                                            <li><a href="gallery-caption-4cols.html">4 Columns</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="gallery-2cols.html">Gallery without Caption</a>
                                        <ul>
                                            <li><a href="gallery-2cols.html">2 Columns</a></li>
                                            <li><a href="gallery-3cols.html">3 Columns</a></li>
                                            <li><a href="gallery-4cols.html">4 Columns</a></li>
                                        </ul>
                                    </li>
                                </ul> -->
                            </li>
                            <!-- <li class="megamenu"><a href="javascrip:void(0)">Mega Menu</a>
                                <ul class="dropdown">
                                    <li>
                                        <div class="megamenu-container container">
                                            <div class="row">
                                                <div class="col-md-3 megamenu-col">
                                                    <span class="megamenu-sub-title"><i class="fa fa-bookmark"></i> Features</span>
                                                    <ul class="sub-menu">
                                                        <li><a href="shortcodes.html">Shortcodes</a></li>
                                                        <li><a href="typography.html">Typography</a></li>
                                                        <li><a href="privacy-policy.html">Privacy policy</a></li>
                                                        <li><a href="payment-terms.html">Payment terms</a></li>
                                                        <li><a href="refund-policy.html">Refund policy</a></li>
                                                    </ul>
                                                </div>
                                                <div class="col-md-3 megamenu-col">
                                                    <span class="megamenu-sub-title"><i class="fa fa-newspaper-o"></i> Latest news</span>
                                                    <div class="widget recent_posts">
                                                        <ul>
                                                            <li>
                                                                <a href="single-post.html" class="media-box">
                                                                    <img src="images/post1.jpg" alt="">
                                                                </a>
                                                                <h5><a href="single-post.html">A single person can change million lives</a></h5>
                                                                <span class="meta-data grid-item-meta">Posted on 11th Dec, 2015</span>
                                                            </li>
                                                            <li>
                                                                <a href="single-post.html" class="media-box">
                                                                    <img src="images/post3.jpg" alt="">
                                                                </a>
                                                                <h5><a href="single-post.html">Donate your woolens this winter</a></h5>
                                                                <span class="meta-data grid-item-meta">Posted on 11th Dec, 2015</span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 megamenu-col">
                                                    <span class="megamenu-sub-title"><i class="fa fa-microphone"></i> Latest causes</span>
                                                    <ul class="widget_recent_causes">
                                                        <li>
                                                            <a href="#" class="cause-thumb">
                                                                <img src="images/cause1.jpg" alt="" class="img-thumbnail">
                                                                <div class="cProgress" data-complete="88" data-color="42b8d4">
                                                                    <strong></strong>
                                                                </div>
                                                            </a>
                                                            <h5><a href="single-cause.html">Help small shopkeepers of Sunyani</a></h5>
                                                            <span class="meta-data">10 days left to achieve</span>
                                                        </li>
                                                        <li>
                                                            <a href="#" class="cause-thumb">
                                                                <img src="images/cause5.jpg" alt="" class="img-thumbnail">
                                                                <div class="cProgress" data-complete="75" data-color="42b8d4">
                                                                    <strong></strong>
                                                                </div>
                                                            </a>
                                                            <h5><a href="single-cause.html">Save tigers from poachers</a></h5>
                                                            <span class="meta-data">32 days left to achieve</span>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="col-md-3 megamenu-col">
                                                    <span class="megamenu-sub-title"><i class="fa fa-star"></i> Featured Video</span> 
                                                    <div class="fw-video"><iframe src="https://player.vimeo.com/video/62947247" width="500" height="275"></iframe></div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                  </ul>
                              </li>
                            <li><a href="blog.html">Blog</a>
                                <ul class="dropdown">
                                    <li><a href="blog.html">Blog Classic</a></li>
                                    <li><a href="blog-grid.html">Blog Grid</a></li>
                                    <li><a href="single-post.html">Single Post</a></li>
                                </ul>
                            </li> -->
                            
                            <?php
                        }
                    ?>
              	</ul>
            </div>
        </header>

        <!-- <header class="site-header">
            <div class="container">
                <div class="site-logo">
                    <a href="index-2.html" class="default-logo"><img src="images/logo.png" alt="Logo"></a>
                    <a href="index-2.html" class="default-retina-logo"><img src="images/logo%402x.png" alt="Logo" width="199" height="30"></a>
                    <a href="index-2.html" class="sticky-logo"><img src="images/sticky-logo.png" alt="Logo"></a>
                    <a href="index-2.html" class="sticky-retina-logo"><img src="images/sticky-logo%402x.png" alt="Logo" width="199" height="30"></a>
                </div>
             	<a href="#" class="visible-sm visible-xs" id="menu-toggle"><i class="fa fa-bars"></i></a>
                <div class="header-info-col"><i class="fa fa-phone"></i> 1800-9090-8089</div>
                <ul class="sf-menu dd-menu pull-right" role="menu">
                    <li><a href="index-2.html">Home</a>
                            <ul>
                                <li><a href="index2.html">Home version 2</a></li>
                                <li><a href="index3.html">Home version 3</a></li>
                                <li><a href="index-2.html">Header Styles</a>
                                    <ul>
                                        <li><a href="index-2.html">Style 1 (Default)</a></li>
                                        <li><a href="header-style2.html">Style 2</a></li>
                                        <li><a href="header-style3.html">Style 3</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    <li><a href="about.html">About</a>
                    	<ul>
                    		<li><a href="about.html">Introduction</a></li>
                    		<li><a href="team.html">Team</a></li>
                    		<li><a href="our-impact.html">Our Impact</a></li>
                    		<li><a href="careers.html">Careers</a></li>
                    		<li><a href="contact.html">Contact</a></li>
                        </ul>
                    </li>
                    <li><a href="causes.html">Causes</a>
                    	<ul>
                    		<li><a href="causes.html">Causes List</a></li>
                    		<li><a href="causes-grid.html">Causes Grid</a></li>
                    		<li><a href="single-cause.html">Single Cause</a></li>
                        </ul>
                    </li>
                    <li><a href="events.html">Events</a>
                    	<ul>
                    		<li><a href="events.html">Events List</a></li>
                    		<li><a href="events-grid.html">Events Grid</a></li>
                    		<li><a href="events-calendar.html">Events Calendar</a></li>
                    		<li><a href="single-event.html">Single Event</a></li>
                        </ul>
                    </li>
                    <li><a href="gallery-caption-2cols.html">Gallery</a>
                    	<ul>
                    		<li><a href="gallery-caption-2cols.html">Gallery with Caption</a>
                                <ul>
                                    <li><a href="gallery-caption-2cols.html">2 Columns</a></li>
                                    <li><a href="gallery-caption-3cols.html">3 Columns</a></li>
                                    <li><a href="gallery-caption-4cols.html">4 Columns</a></li>
                                </ul>
                            </li>
                    		<li><a href="gallery-2cols.html">Gallery without Caption</a>
                                <ul>
                                    <li><a href="gallery-2cols.html">2 Columns</a></li>
                                    <li><a href="gallery-3cols.html">3 Columns</a></li>
                                    <li><a href="gallery-4cols.html">4 Columns</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="megamenu"><a href="javascrip:void(0)">Mega Menu</a>
                        <ul class="dropdown">
                            <li>
                                <div class="megamenu-container container">
                                    <div class="row">
                                        <div class="col-md-3 megamenu-col">
                                        	<span class="megamenu-sub-title"><i class="fa fa-bookmark"></i> Features</span>
                                            <ul class="sub-menu">
                                                <li><a href="shortcodes.html">Shortcodes</a></li>
                                                <li><a href="typography.html">Typography</a></li>
                                                <li><a href="privacy-policy.html">Privacy policy</a></li>
                                                <li><a href="payment-terms.html">Payment terms</a></li>
                                                <li><a href="refund-policy.html">Refund policy</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-md-3 megamenu-col">
                                        	<span class="megamenu-sub-title"><i class="fa fa-newspaper-o"></i> Latest news</span>
                                        	<div class="widget recent_posts">
                                            	<ul>
                                                	<li>
                                                    	<a href="single-post.html" class="media-box">
                                                            <img src="images/post1.jpg" alt="">
                                                        </a>
                                                		<h5><a href="single-post.html">A single person can change million lives</a></h5>
                                                		<span class="meta-data grid-item-meta">Posted on 11th Dec, 2015</span>
                                                    </li>
                                                	<li>
                                                    	<a href="single-post.html" class="media-box">
                                                            <img src="images/post3.jpg" alt="">
                                                        </a>
                                                		<h5><a href="single-post.html">Donate your woolens this winter</a></h5>
                                                		<span class="meta-data grid-item-meta">Posted on 11th Dec, 2015</span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-md-3 megamenu-col">
                                        	<span class="megamenu-sub-title"><i class="fa fa-microphone"></i> Latest causes</span>
                                            <ul class="widget_recent_causes">
                                                <li>
                                                    <a href="#" class="cause-thumb">
                                                        <img src="images/cause1.jpg" alt="" class="img-thumbnail">
                                                        <div class="cProgress" data-complete="88" data-color="42b8d4">
                                                            <strong></strong>
                                                        </div>
                                                    </a>
                                                    <h5><a href="single-cause.html">Help small shopkeepers of Sunyani</a></h5>
                                                    <span class="meta-data">10 days left to achieve</span>
                                                </li>
                                                <li>
                                                    <a href="#" class="cause-thumb">
                                                        <img src="images/cause5.jpg" alt="" class="img-thumbnail">
                                                        <div class="cProgress" data-complete="75" data-color="42b8d4">
                                                            <strong></strong>
                                                        </div>
                                                    </a>
                                                    <h5><a href="single-cause.html">Save tigers from poachers</a></h5>
                                                    <span class="meta-data">32 days left to achieve</span>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-md-3 megamenu-col">
                                        	<span class="megamenu-sub-title"><i class="fa fa-star"></i> Featured Video</span> 
                                            <div class="fw-video"><iframe src="https://player.vimeo.com/video/62947247" width="500" height="275"></iframe></div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                      	</ul>
                  	</li>
                    <li><a href="blog.html">Blog</a>
                        <ul class="dropdown">
                            <li><a href="blog.html">Blog Classic</a></li>
                            <li><a href="blog-grid.html">Blog Grid</a></li>
                            <li><a href="single-post.html">Single Post</a></li>
                        </ul>
                    </li>
              	</ul>
            </div>
        </header> -->
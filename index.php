<?php
    include('include/connection.php');
    include('include/query_helper.php');

    // if(!isset($_SESSION['rbv_init_user']))
    // {
    //     // header("Location:".BASE_FOLDER."");
    //     // exit();
    // }
    // else
    // {
    //     var_dump($_SESSION['rbv_init_user']);
    // }
?>

<!DOCTYPE HTML>
<html class="no-js">


<head>
<!-- Basic Page Needs
  ================================================== -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Riverbridge Initiatives</title>
<meta name="description" content="Riverbridge Initiatives">
<meta name="keywords" content="Riverbridge Initiatives,RBV Initiatives, Initiatives">
<meta name="author" content="Punit Panchal">

<?php include("rbv_head.php") ?>
</head>

<body class="home">
<!--[if lt IE 7]>
	<p class="chromeframe">You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better experience this site.</p>
<![endif]-->
<div class="body">
	<!-- Site Header Wrapper -->
    <div id="section-home" class="site-header-wrapper">
        <?php include("rbv_header.php") ?>
    </div>
    <!-- Hero Area -->
    <div class="hero-area">
        <?php include("rbv_slider.php") ?>
    </div>
    <div class="featured-links row">
    	<a href="#section-initiatives" class="page-scroll featured-link col-md-4 col-sm-4">
        	<span>&nbsp;</span>
        	<strong style="font-weight:normal">View our Causes</strong>
        </a>
    	<a href="javascript:void(0);" data-toggle="modal" data-target="#LoginModal" class="featured-link col-md-4 col-sm-4">
            <span>&nbsp;</span>
        	<strong style="font-weight:normal">Register</strong>
        </a>
    	<a href="#section-contact" class="page-scroll featured-link col-md-4 col-sm-4">
            <span>&nbsp;</span>
        	<strong style="font-weight:normal">Connect with Us</strong>
        </a>
    </div>
    <!-- Main Content -->
    <div id="main-container">
    	<div class="content">

        	<div id="section-about" class="lgray-bg padding-tb75">
            	<div class="container">
                	<div class="row">
                    	<div class="col-md-12 col-sm-12">
                            <div class="text-align-center">
                                <h2 class="block-title block-title-center">About</h2>
                            </div>
                        	<div class="spacer-10"></div>
                            <p style="font-size:17px;" class="text-align-center"><strong>Riverbridge Initiatives</strong> is an <strong>Empowering Platform</strong> with a Collaborative approach enabling</p> 
                            <p style="font-size:17px;" class="text-align-center"> <strong>Dissemination of Innovations</strong> in an <strong>Inclusive</strong>, <strong>Affordable</strong> and <strong>Sustainable</strong> manner.</p>
                            <p style="font-size:17px;" class="text-align-center">The focus is on creating a robust Platform to enhance the quality of living with basic tenets –</p>
                            <p style="font-size:17px;" class="text-align-center">
                                <div class="col-md-3 col-md-offset-4 col-xs-6">
                                    <ul>
                                        <li style="font-size:17px;"><strong>Learning</strong></li>
                                        <li style="font-size:17px;"><strong>Productivity</strong> </li>
                                        <li style="font-size:17px;"><strong>Financial Inclusion</strong></li>
                                    </ul>
                                </div>
                                <div class="col-md-3 col-xs-6">
                                    <ul>
                                        <li style="font-size:17px;"><strong>Employability</strong></li>
                                        <li style="font-size:17px;"><strong>Wellness</strong></li>
                                        <li style="font-size:17px;"><strong>Sports</strong></li>
                                    </ul>
                                </div>
                            </p>
                            <div class="clearfix"></div>
                            <br>
                            <p style="font-size:17px;" class="text-align-center">The philosophy of Riverbridge Initiatives is to foster <strong>Inclusion</strong> by bridging the gap between urban-rural and <strong>affordable-not so affordable</strong>.</p>

                        	<!-- <p class="text-justify">Riverbridge Initiatives is the Social Empowerment Arm of Riverbridge Ventures. It offers an Empowering Platform to the Social Segment through a Collaborative approach, enabling dissemination of Innovations in an Inclusive, Affordable and Sustainable manner.</p>
                            <p class="text-justify">The focus is on creating a strong foundation within this class to enhance the quality of living by covering the basic tenets – Learning, Employability, Productivity, Credit, Sports & Wellness. </p>
                            <p class="text-justify">Riverbridge Initiative's philosophy is to bridge the gap between Urban & Rural as well as between the Affordable  &  Not so Affordable segments of the Society, thus fostering an Inclusion rather than widening the gap. 
                            </p> -->

                        </div>
                  	</div>
                    
               	</div>
            </div>
            
            <div id="section-initiatives" class="padding-tb75 padding-b0">
                <div class="container">
                	<div class="text-align-center">
                           <h2 class="block-title block-title-center">Initiatives</h2>
                           <div id="section-education" style="padding-top:10px"> &nbsp;</div>       
                    </div>                
                </div>

                <?php
                    // List of all Clients
                    $res_get_clients = lookup_value('tbl_clients', array(), array('client_status'=>1),array(),array(),array(),array('client_sort_order'));

                    if($res_get_clients)
                    {
                        $html_data = '';

                        while ($row_get_clients = mysqli_fetch_array($res_get_clients)) 
                        {
                            $client_id         = $row_get_clients['client_id'];
                            $client_name       = $row_get_clients['client_name'];
                            $client_micro_link = $row_get_clients['client_micro_link'];
                            $client_api_link   = $row_get_clients['client_api_link'];
                            $client_desc_1     = $row_get_clients['client_desc_1'];
                            $client_desc_2     = $row_get_clients['client_desc_2'];
                            $client_img_1      = $row_get_clients['client_img_1'];
                            $client_img_2      = $row_get_clients['client_img_2'];
                            $client_sort_order = $row_get_clients['client_sort_order'];
                            
                            $html_data .= '<div class="parallax parallax-light text-align-center padding-tb100" style="background-image:url(images/'.$client_img_1.')">';
                                $html_data .= $client_desc_1;
                            $html_data .= '</div>';

                            $html_data .= '<div class="carousel-wrapper">';
                                $html_data .= '<div class="row">';

                                    if($client_sort_order%2 != 0)
                                    {
                                        $html_data .= '<div class="col-md-6">';
                                            $html_data .= '<img src="images/'.$client_img_2.'" alt="" class="img-responsive">';
                                        $html_data .= '</div>';   
                                    }
               
                                    $html_data .= '<div class="col-md-6">';
                                        $html_data .= '<div class="story-slider-content">';
                                            $html_data .= '<div class="story-slider-table">';
                                                $html_data .= '<div class="story-slider-cell">';
                                                    $html_data .= '<blockquote>';
                                                        $html_data .= '<h3>'.$client_name.'</h3>';
                                                        $html_data .= $client_desc_2;

                                                        if(isset($_SESSION['rbv_init_user']))
                                                        {
                                                            // check already participated or not
                                                            $row_chk_participated = check_exist('tbl_user_client_token', array('uct_user_id'=>$_SESSION['rbv_init_user']['user_id'], 'uct_client_id'=>$client_id));
                                                            
                                                            if($row_chk_participated)
                                                            {
                                                                $uct_status = $row_chk_participated['uct_status'];

                                                                if($uct_status) // Status == 1
                                                                {
                                                                    // chk expiry date
                                                                    // if not expired show "GO TO" btn
                                                                    $html_data .= '<a href="'.$client_micro_link.'" class="btn btn-primary" target="_blank">Go To</a>';  
                                                                    // else renew the token
                                                                    // ask Punit sir for further process
                                                                }
                                                                else    // status == 0
                                                                {
                                                                    // pending [ask punit sir]
                                                                }
                                                            }
                                                            else
                                                            {
                                                                $userid            = (string)$_SESSION['rbv_init_user']['user_id'];
                                                                $clientid          = (string)$client_id;
                                                                $user_client_token = md5($userid.$clientid);

                                                                $html_data .= '<a href="javascript:void(0);" class="btn btn-primary" onClick="getParticipate('.$_SESSION['rbv_init_user']['user_id'].', \''.$user_client_token.'\', '.$client_id.', \''.$client_micro_link.'\', \''.$client_api_link.'\');">Participated</a>';  
                                                            }
                                                        }
                                                    $html_data .= '</blockquote>';                                                    
                                                $html_data .= '</div>';
                                            $html_data .= '</div>';
                                        $html_data .= '</div>';
                                    $html_data .= '</div>';

                                    if($client_sort_order%2 == 0)
                                    {
                                        $html_data .= '<div class="col-md-6">';
                                            $html_data .= '<img src="images/'.$client_img_2.'" alt="" class="img-responsive">';
                                        $html_data .= '</div>';
                                    }

                                $html_data .= '</div>';

                                $html_data .= '<div id="section-skill" style="padding-top:10px"> &nbsp;</div>';
                            $html_data .= '</div>';
                        }
                        echo $html_data;
                    }
                ?>
            </div>
            
            <div id="section-team" class="padding-tb75 lgray-bg">
                <div class="container">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="text-align-center">
                                    <h2 class="block-title block-title-center">Innovations Partner</h2>
                                </div>
                                <h4 class="text-capitalize">Riverbridge Ventures – 'Enabling Innovations'</h4>
                                <p class="text-justify">Riverbridge Ventures, a Venture Platform, is redefining the space of Innovations Enablement through its proprietary <strong>Collaborative Partnership Platform.</strong> It is an <strong>Engagement Partnership Model</strong> beyond mere investment to enable and scale innovations.</p>
                                <p class="text-justify">Conceptualized in 2015 to address the significant gap in the Start-up eco system, Riverbridge currently operates in the fields of AI, Geo-Spatial, Edtech/Learning, Skill, AgriTech, Wellness as well as Last mile Dissemination with cutting edge Innovations. </p>
                                <a href="http://www.riverbridgeventures.com" class="btn btn-primary" target="_blank">Learn More</a>
                            </div>
                            
                        </div>
                        
                    </div>
                </div>
            
            <div class="spacer-75"></div>
        	<div class="container">
            	<div class="row">
                	<div class="col-md-12 content-block">
                    	<form method="post" id="contactform" name="contactform" class="contact-form clearfix" action="contactaction.php">
                        	<div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <input type="text" id="name" name="name"  class="form-control input-lg" placeholder="Name*">
                                    </div>
                                    <div class="form-group">
                                        <input type="email" id="email" name="email"  class="form-control input-lg" placeholder="Email Address*">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" id="phone" name="phone" class="form-control input-lg" placeholder="Phone Number">
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <textarea cols="6" rows="8" id="comments" name="comments" class="form-control input-lg" placeholder="Your Message"></textarea>
                                    </div>
                                    <input id="submit" name="submit" type="submit" class="btn btn-primary btn-lg pull-right" value="Submit now!">
                              	</div>
                           	</div>
                		</form>
                        <div class="clearfix"></div>
                        <div id="message"></div>
                    </div>
                </div>
            </div>    
            
            
        </div>
    </div>
                            
        <?php include("rbv_footer.php") ?>
</div>

<?php include("rbv_modal.php") ?>

<?php include("rbv_javascript.php") ?>

</body>
</html>
<?php 
if(is_page('Apply Employer Register')){
include_once('libs/pages/apply-employer-register.php');	
exit();
}
include_once('header.php');
include_once("libs/nav.php"); 
if(is_page("about-us")){
include_once('libs/pages/about-us.php');	
}else if(is_page("news")){
include_once('libs/pages/news.php');	
}else if(is_page("employer-register")){
include_once('libs/pages/employer-register.php');	
}else if(is_page("Edit Resume")){
include_once('libs/pages/employer-register.php');	
}else if(is_page("request-resume")){
include_once('libs/pages/request-resume.php');	
}else if(is_page("favorite-candidate")){
include_once('libs/pages/favorite-candidate.php');	
}else if(is_page("contact-candidate")){
include_once('libs/pages/contact-candidate.php');	
}else if(is_page("search-candidate")){
include_once('libs/pages/search-candidate.php');	
}else if(is_page("candidate-list")){
include_once('libs/pages/candidate-list.php');	
}else if(is_page("employer")){
include_once('libs/pages/employer.php');	
}else if(is_page("company-profile")){
echo $_REQUEST['company'];
}else if(is_page("contact")){
include_once('libs/pages/contact.php');	
}

include_once('footer.php');?>

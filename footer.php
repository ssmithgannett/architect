<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Architect_2
 */

?>

</div><!-- #content -->

<div class="arch_footer">

	<p class="custom_footer_text"><?php echo get_theme_mod('footer-input') ?></p>
	<p class="gh_copyright"><a href="https://gannett.com">&copy; Gannett Co., Inc. 2020. All Rights Reserved.</a></p>
</div>
</div><!-- #page -->

<?php wp_footer(); ?>

<script>
jQuery('document').ready(function(){
	if (jQuery('.byline_author2').text() == '') {
		jQuery('.secondAuthor').css('height', '0');
		jQuery('.thirdAuthor').css('height', '0');
	};

	if (jQuery('.byline_author3').text() == '') {
		jQuery('.thirdAuthor').css('height', '0');
	};



	var firstGraphHeight = jQuery('p.has-drop-cap').height();

	var graphHeightLimit = 75;
	if(firstGraphHeight < graphHeightLimit) {
		jQuery('p.has-drop-cap').addClass('smallDropCap');
	}
	else if (firstGraphHeight > graphHeightLimit){
		jQuery('p.has-drop-cap').removeClass('smallDropCap');
	}

});

var w = 0;
jQuery(window).on('load',function(){
	w = jQuery(window).width();
});

jQuery(window).resize(function() {

	if (w != jQuery(window).width()) {

		var firstGraphHeight = jQuery('p.has-drop-cap').height();

		var graphHeightLimit = 75;
		if(firstGraphHeight < graphHeightLimit) {
			jQuery('p.has-drop-cap').addClass('smallDropCap');
		}
		else if (firstGraphHeight > graphHeightLimit){
			jQuery('p.has-drop-cap').removeClass('smallDropCap');
		}

	w = jQuery(window).width();
	delete w;
	}

});

jQuery(document).ready(function() {
	jQuery('.entry-content > :first-child').css({'margin-top': '0px'});
});


jQuery(window).on('scroll',function(){
 var mainbottom = 0;


 var stop = 0;
 stop = Math.round(jQuery(window).scrollTop());


 if (stop > mainbottom) {
 jQuery('#masthead').addClass('colorInverse');
 } else {
 jQuery('#masthead').removeClass('colorInverse');
	 }
	 });

	// Smooth scroll
	$(document).ready(function(){
	       /* Add smooth scrolling to all links */
	       $(".arch-nav-expand a").on('click', function(event) {

	         /* clicked hash link should have value */
	         if (this.hash !== "") {
	           /* Prevent default link click behavior */
	           event.preventDefault();

	           /* get hash value */
	           var hash = this.hash;

	           /* animate for smooth scroll to clicked link */
	           $('html, body').animate({
	             scrollTop: $(hash).offset().top
	           }, 1000, function(){
	           });
	         } /* End if */
	       });
	     });
</script>

<script>
(function (i, s, o, g, r, a, m)
	{
			i['GoogleAnalyticsObject'] = r; i[r] = i[r] || function ()
			{
					(i[r].q = i[r].q || []).push(arguments)
			}, i[r].l = 1 * new Date(); a = s.createElement(o),
			m = s.getElementsByTagName(o)[0]; a.async = 1; a.src = g; m.parentNode.insertBefore(a, m)
	})(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
	<?php echo $GLOBALS['ghAnalytics'] ?>
</script>

<script src="https://despace.design/projects-backend/architect-referral-updated.js"></script>




</body>
</html>

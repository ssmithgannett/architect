<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Architect_2
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
	<meta name="parsely-section" content="Architect" />
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<!-- Google Tag Manager // Adds tracker for the Projects roll-up view -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-K8ZD4NR');</script>

	<!-- End Google Tag Manager -->
	<title><?php echo get_bloginfo('name');?></title>
	<?php wp_head(); ?>

	<?php
	global $post;
	$GLOBALS['category'] = "GatehouseProjects";
	$GLOBALS['author'] = get_the_author_meta( 'display_name', $post->post_author );
	$GLOBALS['keywords'] = "";
	if( get_option( 'data_team_project' ) ) {
			$GLOBALS['category'] = 'investigations';
			$GLOBALS['keywords'] = 'GateHouse Media, National Data & Investigations Team, journalism';
	}
	$GLOBALS['ghDomain'] = 'http://gatehouseprojects.com';
	$GLOBALS['ghAnalytics'] = "ga('create', 'UA-6842750-1', {'name':'firstTracker',});
		ga('create', 'UA-51861146-1', {'name':'secondTracker',});
		ga('create', 'UA-37024380-19', {'name':'fourthTracker',});
		ga('firstTracker.send', 'pageview', {
				'dimension3': '{$GLOBALS['author']}',
				'dimension5': '{$GLOBALS['category']}',
				'dimension8': '{$GLOBALS['keywords']}'
		});
		ga('secondTracker.send', 'pageview', {
				'dimension3': '{$GLOBALS['author']}',
				'dimension5': '{$GLOBALS['category']}',
				'dimension8': '{$GLOBALS['keywords']}'
		});
		ga('fourthTracker.send', 'pageview', {
				'dimension3': '{$GLOBALS['author']}',
				'dimension5': '{$GLOBALS['category']}',
				'dimension8': '{$GLOBALS['keywords']}'
		});";
	$GLOBALS['ghLogo'] = "Gannett";
	$GLOBALS['ghSite'] = "gannett.com";
	$shareLink = get_permalink();
	$pageSlug = $post->post_name;
	global $wp_query;

	if(isset($wp_query->query_vars['site'])) {
		if(!empty($wp_query->query_vars['site'])) {
			$GLOBALS['ghSite'] = $wp_query->query_vars['site'];
			if (strpos($GLOBALS['ghSite'], 'news-jrnl.com') !== false) {
				$GLOBALS['ghSite'] = 'news-journalonline.com';
			}
			if(home_url() . "/" == $shareLink) {
				$shareLink = get_permalink() . "{$pageSlug}/site/{$GLOBALS['ghSite']}";
			} else {
				$shareLink = get_permalink() . "site/{$GLOBALS['ghSite']}";
			}

			$jsonURL = "https://{$GLOBALS['ghSite']}/section/site-data-js.js?map=gatehouseprojects_default";
			$ghSiteContent = file_get_contents("https://{$GLOBALS['ghSite']}/section/site-data-js.js?map=gatehouseprojects_default");
			$ghSiteContent = explode(';', $ghSiteContent);
			$ghSiteContent = str_replace('var __gh__coreData = ', '', $ghSiteContent[0]);
			$ghSiteContent = str_replace(',}', '}', $ghSiteContent);
			$ghSiteContent = str_replace("'[\"section\"]'", '""', $ghSiteContent);
			$ghSiteContent = str_replace("undefined", '""', $ghSiteContent);
			$ghSiteContent = str_replace("<<<<<<<" , "", $ghSiteContent);
			$ghSiteContent = str_replace(".mine" , "", $ghSiteContent);
			$ghSiteContent = str_replace("=======", "", $ghSiteContent);
			$ghSiteContent = str_replace(".r4024", "", $ghSiteContent);
			$ghSiteContent = str_replace (">>>>>>>" , "", $ghSiteContent);
			$json = json_decode($ghSiteContent);

			if(isset($json->siteData->logoURL)){
				$siteLogo = $json->siteData->logoURL;
				$GLOBALS['ghDomain'] = "https://{$GLOBALS['ghSite']}";

			}
			if(isset($json->{'3rdPartyData'}->analytics->google->ua)) {
				$GLOBALS['ghAnalytics'] = "ga('create', 'UA-6842750-1', {'name':'firstTracker',});
				ga('create', 'UA-51861146-1', {'name':'secondTracker',});
				ga('create', '{$json->{'3rdPartyData'}->analytics->google->ua}', {'name':'thirdTracker',});
				ga('create', 'UA-37024380-19', {'name':'fourthTracker',});
				ga('firstTracker.send', 'pageview', {
						'dimension3': '{$GLOBALS['author']}',
						'dimension5': '{$GLOBALS['category']}',
						'dimension8': '{$GLOBALS['keywords']}'
				});
				ga('secondTracker.send', 'pageview', {
						'dimension3': '{$GLOBALS['author']}',
						'dimension5': '{$GLOBALS['category']}',
						'dimension8': '{$GLOBALS['keywords']}'
				});
				ga('thirdTracker.send', 'pageview', {
						'dimension3': '{$GLOBALS['author']}',
						'dimension5': '{$GLOBALS['category']}',
						'dimension8': '{$GLOBALS['keywords']}'
				})
				ga('fourthTracker.send', 'pageview', {
						'dimension3': '{$GLOBALS['author']}',
						'dimension5': '{$GLOBALS['category']}',
						'dimension8': '{$GLOBALS['keywords']}'
				});";
					}


					$GLOBALS['ghLogo'] = $json->siteData->siteTitle;
			if (strpos($GLOBALS['ghLogo'], 'The Register Guard') !== false) {
				$GLOBALS['ghLogo'] = 'The Register-Guard';
			}

					$GLOBALS['dfpID'] = $json->{'3rdPartyData'}->ads->dfp->id;
		}
	}

	wp_reset_query();
	?>


	<style type="text/css">
		<?php
		$brandingType = get_theme_mod( 'ghp_branding_radio_setting_id' );
		if($brandingType == 'logo'){
		?>
			.gh-sitename { display:none; }
			.gh-logo { margin: 0; display: block; }
		<?php
		}
		?>
	</style>
	<script
	  src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.js" crossorigin="anonymous"></script>

</head>

<body <?php body_class(); ?>>
	<?php
		$tracking_content = file_get_contents( "https://s3.amazonaws.com/despace.design/projects-backend/architect-referral-updated.js" );
		$pattern = "/\[(.*?)\]/m";
		preg_match($pattern, $tracking_content, $matches, PREG_OFFSET_CAPTURE, 0);
		$sites_array = json_decode( $matches[0][0] );
		$site_var = $wp_query->query_vars['site'];
		if( isset( $site_var ) && $site_var != "" ) {
		    if( in_array( $site_var, $sites_array ) ) {
		        echo "<!-- Parsely script START --><script id='parsely-cfg' src='//cdn.parsely.com/keys/$site_var/p.js'></script><!-- Parsely script END -->";
		    } if($GLOBALS['ghSite'] == 'beaconjournal.com') {
						echo "<!-- Parsely script START --><script id='parsely-cfg' src='//cdn.parsely.com/keys/ohio.com/p.js'></script><!-- Parsely script END -->";
				} else {
		        echo "<!-- Parsely script START --><script id='parsely-cfg' src='//cdn.parsely.com/keys/stories.usatodaynetwork.com/p.js'></script><!-- Parsely script END -->";
		    }
		}
		else {
		    echo "<!-- Parsely script START --><script id='parsely-cfg' src='//cdn.parsely.com/keys/stories.usatodaynetwork.com/p.js'></script><!-- Parsely script END -->";
		}
		$article_date_time = get_the_date() . ' ' . get_post_time( 'G:i' );
		$article_date_time = date( 'Y-m-d\TH:i:s\Z', strtotime( $article_date_time ) );
		?>

		<!-- Parsely metadata START -->
		<script type="application/ld+json">
		{
			"@context": "http://schema.org",
			"@type": "NewsArticle",
			"headline": "<?php the_title(); ?>",
			"url": "<?php the_permalink(); ?>",
			"thumbnailUrl": "<?php echo get_the_post_thumbnail_url(); ?>",
			"datePublished": "<?php echo $article_date_time; ?>",
			"creator": ["<?php echo get_the_author_meta('display_name'); ?>"],
			"section": "Architect"
		}
		</script>
		<!-- Parsely metadata END -->

	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-K8ZD4NR"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->
	<div id="page" class="site <?php esc_html_e( get_theme_mod( 'arch_theme_name' ) ); ?>">

		<header id="masthead" class="site-header" role="banner">

		<div class="arch-nav">

						<div class="gh-logo-wrap"><a target="_blank" class="arch-nav-branding gh-logo" href="http://<?php echo $GLOBALS['ghSite'] ?>"><img src="<?php echo $siteLogo ?>"/></a></div>
						<div class="site-name-wrap"><a class="site-name" href="<?php echo home_url() ?>/home/site/<?php echo $GLOBALS['ghSite'] ?>"><?php echo get_bloginfo('name');?></a></div>
						<div class="arch-nav-toggle-wrap"><a class="arch-nav-toggle <?php esc_html_e( get_theme_mod( 'arch_menu' ) ); ?>">+</a></div>


		</div> <!-- arch-nav -->
	</header><!-- #masthead -->

	<div class="arch-nav-expand hidden">
	<?php /* Primary navigation */
			wp_nav_menu( array(
				'theme_location' => '',
				'depth'          => 2,
				'container'      => false,
				'menu_class'     => '',
			//  'walker'		 => new wp_bootstrap_navwalker()
				)
			);
	?>
	</div><!-- arch-nav-expand -->
	<script>
	if (jQuery('.gh-logo img').attr('src') == '' && jQuery('.gh-sitename').text().length) {
		jQuery('.gh-sitename').attr('style', 'display:block;');
		jQuery('.gh-logo').attr('style', 'display:none');
	}

	jQuery('.arch-nav-toggle').click(function() {
		jQuery('.arch-nav-toggle').toggleClass('rotate');
		jQuery('.arch-nav-expand').toggleClass('hidden');
		jQuery('body').toggleClass('noScroll');
	});

	jQuery('.arch-nav-expand a').click(function() {
		jQuery('.arch-nav-toggle').toggleClass('rotate');
		jQuery('.arch-nav-expand').toggleClass('hidden');
		jQuery('body').toggleClass('noScroll');
	});


	</script>

	<script>
		var nav = jQuery('.nav.navbar-nav ul');
		if(nav.hasClass('nav')) {

		} else {
			nav.addClass('nav');
			nav.addClass('navbar-nav');
		}
	</script>

	<!-- begin site content below -->
	<div id="content" class="site-content">

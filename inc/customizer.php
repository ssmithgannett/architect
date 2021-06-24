<?php
/**
 * Architect 2 Theme Customizer
 *
 * @package Architect_2
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function architect_2_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'architect_2_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'architect_2_customize_partial_blogdescription',
		) );
	}

	// Architect style switcher

	$wp_customize->add_section( 'architect_options',
	 array(
			'title'       => __( 'Architect Styles', 'architect' ), //Visible title of section
			'priority'    => 9, //Determines what order this appears in
			'capability'  => 'edit_theme_options', //Capability needed to tweak
			'description' => __('Allows you to customize settings for Theme.', 'architect'), //Descriptive tooltip
	 )
	);

	$wp_customize->add_setting( 'arch_theme_name', //No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
	 array(
			'default'    => 'default', //Default setting/value to save
			'type'       => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
			'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
			//'transport'  => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
	 )
	);

	$wp_customize->add_control( new WP_Customize_Control(
	 $wp_customize, //Pass the $wp_customize object (required)
	 'architect_theme_name', //Set a unique ID for the control
	 array(
			'label'      => __( 'Select Architect Style', 'architect' ), //Admin-visible name of the control
			'description' => __( 'You can change the color and type styles of the site with this option.' ),
			'settings'   => 'arch_theme_name', //Which setting to load and manipulate (serialized is okay)
			'priority'   => 9, //Determines the order this control appears in for the specified section
			'section'    => 'architect_options', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
			'type'    => 'select',
			'choices' => array(
					'default' => 'Classic',
					'bold' => 'Bold',
					'cool' => 'Cool',
					'warm' => 'Warm',
					'dark' => 'Dark',
			)
	)
	) );


	// Footer bio panel

		$wp_customize->add_panel( 'footer-bio', array(
			'priority' => 10,
			'capability' => 'edit_theme_options',
			'theme_supports' => '',
			'title' => __( 'Architect Footer', 'Sean&apos;s first theme' ),
			'description' => __( 'Edit the paragraph text in the site&apos;s footer.', 'Sean&apos;s first theme' ),
			) );

	//bio text input

		$wp_customize->add_section( 'footer-input',
			array(
				'title'						=> __('Footer text', 'Seans first theme'),
				'priority'				=> 11,
				'panel'						=> 'footer-bio',
			) );

		$wp_customize->add_setting( 'footer-input',
			array(
				'capability'			=> 'edit_theme_options',
				'default'					=> 'Lorem Ipsum',
				'sanitize_callback' => 'sanitize_text_field',
			) );

		$wp_customize->add_control( 'footer-input',
			array(
				'type'						=> 'text',
				'section'					=> 'footer-input', // Add a default or your own section
				'setting'					=> 'footer-input',
				'label'						=> __( 'Footer Text' ),
				'description'			=> __( 'Custom text you can add to the footer, such as an author bio, information about the publication or story, etc.' ),
			) );

			//Menu toggle
			$wp_customize->add_section( 'architect_menu_toggle',
			 array(
					'title'       => __( 'Architect Menu', 'architect' ), //Visible title of section
					'priority'    => 9, //Determines what order this appears in
					'capability'  => 'edit_theme_options', //Capability needed to tweak
					'description' => __('Allows you to customize settings for Theme.', 'architect'), //Descriptive tooltip
			 )
			);

			$wp_customize->add_setting( 'arch_menu', //No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
			 array(
					'default'    => 'default', //Default setting/value to save
					'type'       => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
			//		'capability' => 'toggle', //Optional. Special permissions for accessing this setting.
					//'transport'  => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			 )
			);

			$wp_customize->add_control( new WP_Customize_Control(
			 $wp_customize, //Pass the $wp_customize object (required)
			 'architect_menu_toggler', //Set a unique ID for the control
			 array(
					'label'      => __( 'Toggle the site menu', 'architect' ), //Admin-visible name of the control
					'description' => __( 'You can show or hide the menu toggle (+) with this setting.' ),
					'settings'   => 'arch_menu', //Which setting to load and manipulate (serialized is okay)
					'priority'   => 9, //Determines the order this control appears in for the specified section
					'section'    => 'architect_menu_toggle', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
					'type'    => 'radio',
					'choices' => array(
							'default' => 'Off',
							'on' => 'On',
					)
			)
			) );










}
add_action( 'customize_register', 'architect_2_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function architect_2_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function architect_2_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function architect_2_customize_preview_js() {
	wp_enqueue_script( 'architect-2-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'architect_2_customize_preview_js' );

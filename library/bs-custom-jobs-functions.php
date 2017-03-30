<?php
//Adding Wages Field to front-end
add_filter( 'submit_job_form_fields', 'frontend_add_wages_field' );
function frontend_add_wages_field( $fields ) {
    $fields['job']['job_salary'] = array(
        'label'       => __( 'Wages ($)', 'job_manager' ),
        'type'        => 'text',
        'required'    => false,
        'placeholder' => 'e.g. 20000, 22/Hour',
        'priority'    => 7
    );
    return $fields;
}

//Adding Wages field to admin area
add_filter( 'job_manager_job_listing_data_fields', 'admin_add_wages_field' );
function admin_add_wages_field( $fields ) {
    $fields['_job_salary'] = array(
        'label'       => __( 'Wages ($)', 'job_manager' ),
        'type'        => 'text',
        'placeholder' => 'e.g. 20000, 22/Hour',
        'description' => ''
    );
    return $fields;
}

//Show wages on individual job page
add_action( 'single_job_listing_meta_end', 'display_job_wages_data' );
function display_job_wages_data() {
    global $post;

    $salary = get_post_meta( $post->ID, '_job_salary', true );

    if ( $salary ) {
        echo '<li>' . __( 'Wages:' ) . ' ' . esc_html( $salary ) . '</li>';
    }
}

//Adding Qualification Field to front-end
add_filter( 'submit_job_form_fields', 'frontend_add_qualifications_field' );
function frontend_add_qualifications_field( $fields ) {
    $fields['job']['job_qualifications'] = array(
        'label'       => __( 'Qualifications ', 'job_manager' ),
        'type'        => 'textarea',
        'required'    => false,
        'placeholder' => '',
        'priority'    => 10
    );
    return $fields;
}

//Adding Wages field to admin area
add_filter( 'job_manager_job_listing_data_fields', 'admin_add_qualifications_field' );
function admin_add_qualifications_field( $fields ) {
    $fields['_job_qualifications'] = array(
        'label'       => __( 'Qualifications ', 'job_manager' ),
        'type'        => 'textarea',
        'placeholder' => '',
        'description' => '',
        'priority'    => 4

    );
    return $fields;
}

//Show wages on individual job page
add_action( 'single_job_listing_meta_end', 'display_job_qualifications_data' );
function display_job_qualifications_data() {
    global $post;

    $salary = get_post_meta( $post->ID, '_job_qualifications', true );

    if ( $salary ) {
        echo '</ul><p class="name"><strong itemprop="name">' . __( 'Qualifications:' ) . '</strong></p><p class="tagline"> ' . esc_html( $salary ) . '</p>';
    }
}
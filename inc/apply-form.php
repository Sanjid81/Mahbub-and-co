<?php
/**
 * Job Apply Form block – shows Contact Form 7 shortcode.
 */
defined('ABSPATH') || exit;

use Carbon_Fields\Block;
use Carbon_Fields\Field;

add_action('carbon_fields_register_fields', 'maco_register_apply_form_block', 20);

function maco_register_apply_form_block()
{
    Block::make(__('Job Apply Form', 'mahbub-and-co'))
        ->set_icon('feedback')
        ->set_category('layout')
        ->add_fields(array(
            Field::make('text', 'apply_form_shortcode', __('Contact Form 7 Shortcode', 'mahbub-and-co'))
                ->set_default_value('[contact-form-7 id="bf793a0" title="Apply Form"]')
                ->help_text(__('Paste the Contact Form 7 shortcode, or leave default.', 'mahbub-and-co')),
        ))
        ->set_render_callback('maco_apply_form_block_render');
}

function maco_apply_form_block_render($fields, $attributes, $inner_blocks)
{
    $shortcode = !empty($fields['apply_form_shortcode']) ? $fields['apply_form_shortcode'] : '[contact-form-7 id="bf793a0" title="Apply Form"]';
    ?>
    <section class="apply-form-section">
        <div class="container">
            <?php echo do_shortcode($shortcode); ?>
        </div>
    </section>
    <?php
}

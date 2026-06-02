<?php
/**
 * Carbon Fields Gutenberg blocks for Job Opening post type.
 */
defined('ABSPATH') || exit;

use Carbon_Fields\Block;
use Carbon_Fields\Field;

add_action('carbon_fields_register_fields', 'maco_register_job_opening_blocks', 20);

/**
 */
add_filter('the_content', 'maco_render_all_job_blocks_fallback', 999); 

function maco_render_all_job_blocks_fallback($content) {
    if (get_post_type() !== 'job_opening') {
        return $content;
    }

    $blocks = [
        'job-description' => [
            'heading_default' => 'Job Description',
            'class' => 'maco-job-block maco-job-block-description',
            'title_tag' => 'h2',
            'title_class' => 'maco-job-block-title',
            'content_key' => 'content',
            'is_rich' => true,
        ],
        'key-requirements' => [
            'heading_default' => 'Key Requirements',
            'class' => 'maco-job-block maco-job-block-requirements',
            'title_tag' => 'h3',
            'title_class' => 'maco-job-block-list-heading',
            'items_key' => 'items',
            'is_list' => true,
        ],
        'key-skills' => [
            'heading_default' => 'Key Skills',
            'class' => 'maco-job-block maco-job-block-skills',
            'title_tag' => 'h3',
            'title_class' => 'maco-job-block-list-heading',
            'items_key' => 'items',
            'is_list' => true,
        ],
    ];

    foreach ($blocks as $block_slug => $cfg) {
        $needle = '<!-- wp:carbon-fields/' . $block_slug . ' ';
        $pos = 0;
        while (($pos = strpos($content, $needle, $pos)) !== false) {
            $json_start = $pos + strlen($needle);
            $brace_pos = strpos($content, '{', $json_start);
            if ($brace_pos === false) { $pos = $json_start; continue; }

            $depth = 1; $end = $brace_pos + 1;
            $len = strlen($content);
            for ($i = $brace_pos + 1; $i < $len; $i++) {
                if ($content[$i] === '{' ) $depth++;
                if ($content[$i] === '}') { $depth--; if ($depth === 0) { $end = $i + 1; break; } }
            }

            $json = substr($content, $brace_pos, $end - $brace_pos);
            $data = json_decode($json, true);
            if (!is_array($data) || empty($data['data'])) { $pos = $json_start; continue; }

            $fields = $data['data'];
            $html = '<div class="' . esc_attr($cfg['class']) . '">';

            $heading = trim($fields['heading'] ?? $cfg['heading_default']);
            if ($heading !== '') {
                $html .= '<' . $cfg['title_tag'] . ' class="' . esc_attr($cfg['title_class']) . '">' 
                      . esc_html($heading) . '</' . $cfg['title_tag'] . '>';
            }

            if (!empty($cfg['is_list'])) {
                $items = $fields[$cfg['items_key']] ?? [];
                $items = array_filter($items, fn($r) => !empty(trim($r['item'] ?? '')));
                if (!empty($items)) {
                    $html .= '<ol class="maco-job-block-list">';
                    foreach ($items as $item) {
                        $html .= '<li>' . wp_kses_post(wpautop($item['item'])) . '</li>';
                    }
                    $html .= '</ol>';
                }
            } elseif (!empty($cfg['is_rich'])) {
                $raw = $fields[$cfg['content_key']] ?? '';
                if ($raw !== '') {
                    $html .= '<div class="maco-job-block-content entry-content">' 
                          . wp_kses_post(apply_filters('the_content', $raw)) . '</div>';
                }
            }

            $html .= '</div>';

            // Replace raw comment
            $closing_pos = strpos($content, '-->', $end);
            $full = ($closing_pos !== false) ? substr($content, $pos, $closing_pos - $pos + 3) : substr($content, $pos, $end - $pos);
            $wrapped = '<p>' . $full . '</p>';
            $content = str_replace($wrapped, $html, $content) ?: str_replace($full, $html, $content);
            $pos += strlen($html);
        }
    }
    return $content;
}

function maco_register_job_opening_blocks() {
    Block::make('Job Description')
        ->set_icon('media-text')->set_category('layout')
        ->where('post_type', '=', 'job_opening')
        ->add_fields([
            Field::make('text', 'heading', __('Section Heading', 'mahbub-and-co'))->set_default_value('Job Description'),
            Field::make('rich_text', 'content', __('Content', 'mahbub-and-co')),
        ])->set_render_callback('maco_job_block_description_render');

    Block::make('Key Requirements')
        ->set_icon('list-view')->set_category('layout')
        ->where('post_type', '=', 'job_opening')
        ->add_fields([
            Field::make('text', 'heading', __('Section Heading', 'mahbub-and-co'))->set_default_value('Key Requirements'),
            Field::make('complex', 'items', __('Requirements', 'mahbub-and-co'))
                ->set_layout('tabbed-horizontal')
                ->add_fields([Field::make('textarea', 'item', __('Requirement', 'mahbub-and-co'))]),
        ])->set_render_callback('maco_job_block_key_requirements_render');

    Block::make('Key Skills')
        ->set_icon('performance')->set_category('layout')
        ->where('post_type', '=', 'job_opening')
        ->add_fields([
            Field::make('text', 'heading', __('Section Heading', 'mahbub-and-co'))->set_default_value('Key Skills'),
            Field::make('complex', 'items', __('Skills', 'mahbub-and-co'))
                ->set_layout('tabbed-horizontal')
                ->add_fields([Field::make('textarea', 'item', __('Skill', 'mahbub-and-co'))]),
        ])->set_render_callback('maco_job_block_key_skills_render');
}

function maco_job_block_description_render($fields, $attributes, $inner) {
    error_log('Job Description render called - Post: ' . get_the_ID()); 
}

function maco_job_block_key_requirements_render($fields, $attributes, $inner) {
    error_log('Key Requirements render called');
    // ...
}

function maco_job_block_key_skills_render($fields, $attributes, $inner) {
    error_log('Key Skills render called');
    // ...
}
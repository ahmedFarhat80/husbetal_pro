<?php
return [
    'mode'                       => 'auto',
    'format'                     => 'A4',
    'default_font_size'          => '12',
    'default_font'               => 'Cairo',
    'margin_left'                => 0,
    'margin_right'               => 0,
    'margin_top'                 => 2,
    'margin_bottom'              => 0,
    'margin_header'              => 0,
    'margin_footer'              => 0,
    'orientation'                => 'l',
    'title'                      => 'هيئة الخدمات الطبية - نظام مواعيد مستشفى العسكري',
    'author'                     => '',
    'watermark'                  => 'علامة مائية',
    'show_watermark'             => false,
    'show_watermark_image'       => true,
    'watermark_font'             => 'Cairo',
    'display_mode'               => 'fullpage',
    'watermark_text_alpha'       => 0.1,
    'watermark_image_path'       => public_path('logo.png'),
    'watermark_image_alpha'      => 0.04,
    'watermark_image_size'       => 'D',
    'watermark_image_position'   => 'P',
    'custom_font_dir'            => 'https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap',
    'custom_font_data'           => [],
    'auto_language_detection'    => true,
    'temp_dir'                   => storage_path('app'),
    'pdfa'                       => false,
    'pdfaauto'                   => true,
    'autoScriptToLang'            => true,
    'autoLangToFont'                => true,
    'use_active_forms'           => true,
];

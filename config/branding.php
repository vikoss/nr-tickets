<?php

/**
 * Branding Configuration
 * 
 * This file configures the application branding including:
 * - Application and company names
 * - Logo paths for light and dark modes
 * - Color palette tokens (exposed via Tailwind config and CSS variables)
 * 
 * Color tokens are exposed to the frontend through:
 * 1. CSS custom properties in resources/css/app.css
 * 2. Tailwind theme extension in tailwind.config.js
 */

return [
    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    | The primary name displayed in the application header and page titles.
    */
    'app_name' => env('BRANDING_APP_NAME', 'NR Tickets'),

    /*
    |--------------------------------------------------------------------------
    | Company Name
    |--------------------------------------------------------------------------
    | The company or organization name displayed in the footer and legal notices.
    */
    'company_name' => env('BRANDING_COMPANY_NAME', 'NR Impuestos'),

    /*
    |--------------------------------------------------------------------------
    | Logo Paths
    |--------------------------------------------------------------------------
    | Paths to logo files relative to the public directory.
    | Provide separate logos for light and dark modes.
    */
    'logos' => [
        'light' => '/images/logo-light.svg',
        'dark' => '/images/logo-dark.svg',
        'favicon' => '/favicon.ico',
    ],

    /*
    |--------------------------------------------------------------------------
    | Color Palette
    |--------------------------------------------------------------------------
    | Primary and accent colors used throughout the application.
    | These values are exposed via CSS custom properties and can be
    | referenced in Tailwind classes using the 'brand' prefix.
    | 
    | Color format: hex values (e.g., '#3B82F6')
    */
    'colors' => [
        // Primary brand color - used for main actions, links, and highlights
        'primary' => [
            '50' => '#EEF2FF',
            '100' => '#E0E7FF',
            '200' => '#C7D2FE',
            '300' => '#A5B4FC',
            '400' => '#818CF8',
            '500' => '#6366F1',  // Main primary
            '600' => '#4F46E5',
            '700' => '#4338CA',
            '800' => '#3730A3',
            '900' => '#312E81',
            '950' => '#1E1B4B',
        ],
        
        // Secondary color - used for secondary actions and accents
        'secondary' => [
            '50' => '#F0FDF4',
            '100' => '#DCFCE7',
            '200' => '#BBF7D0',
            '300' => '#86EFAC',
            '400' => '#4ADE80',
            '500' => '#22C55E',  // Main secondary
            '600' => '#16A34A',
            '700' => '#15803D',
            '800' => '#166534',
            '900' => '#14532D',
            '950' => '#052E16',
        ],

        // Accent color - used for special highlights and notifications
        'accent' => [
            '50' => '#FFF7ED',
            '100' => '#FFEDD5',
            '200' => '#FED7AA',
            '300' => '#FDBA74',
            '400' => '#FB923C',
            '500' => '#F97316',  // Main accent
            '600' => '#EA580C',
            '700' => '#C2410C',
            '800' => '#9A3412',
            '900' => '#7C2D12',
            '950' => '#431407',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Evidence/Image Settings
    |--------------------------------------------------------------------------
    | Configuration for image uploads (evidence files)
    */
    'evidence' => [
        // Maximum file size in kilobytes (default: 5MB)
        'max_size_kb' => (int) env('EVIDENCE_MAX_SIZE_KB', 5120),
        
        // Allowed MIME types for evidence images
        'allowed_mimes' => ['image/jpeg', 'image/jpg', 'image/png'],
        
        // Allowed extensions
        'allowed_extensions' => ['jpg', 'jpeg', 'png'],
        
        // Image compression quality (0-100, higher = better quality)
        'compression_quality' => 85,
        
        // Thumbnail dimensions (optional, for list views)
        'thumbnail' => [
            'width' => 300,
            'height' => 200,
        ],
    ],
];

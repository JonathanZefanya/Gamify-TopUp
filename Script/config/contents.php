<?php
return [
    'dark_hero' => [
        'single' => [
            'field_name' => [
                'trend_title' => 'text',
                'trend_sub_title' => 'text',
            ],
            'validation' => [
                'trend_title.*' => 'required|max:100',
                'trend_sub_title.*' => 'required|max:150',
            ]
        ],
        'multiple' => [
            'field_name' => [
                'title' => 'text',
                'sub_title' => 'text',
                'description' => 'text',
                'kew-text' => 'text',
                'box_type' => 'text',
                'background_image' => 'file',
            ],
            'validation' => [
                'title.*' => 'required|max:100',
                'sub_sub_title.*' => 'required|max:200',
                'description.*' => 'required|max:500',
                'kew-text.*' => 'required|max:300',
                'background_image.*' => 'nullable|max:10240|image|mimes:jpg,jpeg,png,webp,svg',
            ],
        ],
        'preview' => [
            'Dark Theme Image' => 'assets/preview/dark/hero.png'
        ],
        'theme' => 'dark',
    ],
    'dark_about' => [
        'single' => [
            'field_name' => [
                'title' => 'text',
                'description' => 'textarea',
                'button' => 'text',
                'button_link' => 'url',
                'image' => 'file',
            ],
            'validation' => [
                'title.*' => 'required|max:100',
                'description.*' => 'required|max:10050',
                'button.*' => 'required|max:100',
                'button_link.*' => 'required|max:100',
                'image.*' => 'nullable|max:10240|image|mimes:jpg,jpeg,png,webp,svg',
            ]
        ],
        'preview' => [
            'Dark Theme Image' =>'assets/preview/dark/about.png'
            ],
        'theme' => 'dark',
    ],
    'dark_exclusive_card' => [
        'single' => [
            'field_name' => [
                'title' => 'text',
                'sub_title' => 'text',
                'button' => 'text',
                'button_link' => 'url',
            ],
            'validation' => [
                'title.*' => 'required|max:100',
                'sub_title.*' => 'required|max:200',
                'button.*' => 'required|max:100',
                'button_link.*' => 'required|max:100',

            ]
        ],
        'preview' =>[
            'Dark Theme Image' => 'assets/preview/dark/exclusive_card.png'
            ],
        'theme' => 'dark',
    ],
    'dark_campaign' => [
        'single' => [
            'field_name' => [
                'heading' => 'text',
                'title' => 'text',
                'sub_title' => 'text',
                'image' => 'file',
            ],
            'validation' => [
                'heading.*' => 'required|max:100',
                'title.*' => 'required|max:100',
                'sub_title.*' => 'required|max:100',
                'image.*' => 'nullable|max:10240|image|mimes:jpg,jpeg,png,webp,svg',
            ]
        ],
        'preview' =>[
            'Dark Theme Image' => 'assets/preview/dark/campaign.png'
            ],
        'theme' => 'dark',
    ],
    'dark_top_up' => [
        'single' => [
            'field_name' => [
                'title' => 'text',
                'sub_title' => 'text',
                'button' => 'text',
                'button_link' => 'url',
            ],
            'validation' => [
                'title.*' => 'required|max:100',
                'sub_title.*' => 'required|max:100',
                'button.*' => 'required|max:100',
                'button_link.*' => 'required|max:100',
            ]
        ],
        'preview' =>[
            'Dark Theme Image' => 'assets/preview/dark/top_up.png'
            ],
        'theme' => 'dark',
    ],
    'dark_why_chose_us' => [
        'single' => [
            'field_name' => [
                'title' => 'text',
                'sub_title' => 'text',
                'image' => 'file',
            ],
            'validation' => [
                'title.*' => 'required|max:100',
                'sub_title.*' => 'required|max:100',
                'image.*' => 'nullable|max:10240|image|mimes:jpg,jpeg,png,webp,svg',
            ]
        ],
        'multiple' => [
            'field_name' => [
                'title' => 'text',
                'description' => 'text',
            ],
            'validation' => [
                'title.*' => 'required|max:100',
                'description.*' => 'required|max:500',
            ],
        ],
        'preview' =>[
            'Dark Theme Image' => 'assets/preview/dark/why_chose_us.png'
            ],
        'theme' => 'dark',
    ],
    'dark_testimonial' => [
        'single' => [
            'field_name' => [
                'title' => 'text',
                'button' => 'text',
                'button_link' => 'url',
            ],
            'validation' => [
                'title.*' => 'required|max:100',
                'button.*' => 'required|max:100',
                'button_link.*' => 'required|max:100',
            ]
        ],
        'multiple' => [
            'field_name' => [
                'name' => 'text',
                'location' => 'text',
                'review' => 'text',
                'rating' => 'text',
                'image' => 'file'
            ],
            'validation' => [
                'name.*' => 'required|max:100',
                'location.*' => 'required|max:100',
                'review.*' => 'required|max:1000',
                'rating.*' => 'required|max:100',
                'image.*' => 'nullable|max:10240|image|mimes:jpg,jpeg,png,webp,svg',
            ],
        ],
        'preview' =>[
            'Dark Theme Image' => 'assets/preview/dark/testimonial.png'
            ],
        'theme' => 'dark',
    ],
    'dark_blog' => [
        'single' => [
            'field_name' => [
                'title' => 'text',
                'button' => 'text',
                'button_link' => 'url',
            ],
            'validation' => [
                'title.*' => 'required|max:100',
                'button.*' => 'required|max:100',
                'button_link.*' => 'required|max:100',
            ]
        ],
        'preview' =>[
            'Dark Theme Image' => 'assets/preview/dark/blog.png'
            ],
        'theme' => 'dark',
    ],
    'dark_contact' => [
        'single' => [
            'field_name' => [
                'title' => 'text',
                'sub_title' => 'text',
                'form_title' => 'text',
                'form_sub_title' => 'text',
                'email' => 'text',
                'location' => 'text',
                'phone' => 'text',
                'button' => 'text',
                'image' => 'file',
            ],
            'validation' => [
                'title.*' => 'required|max:100',
                'sub_title.*' => 'required|max:200',
                'form_title.*' => 'required|max:100',
                'form_sub_title.*' => 'required|max:200',
                'email.*' => 'required|max:50',
                'location.*' => 'required|max:200',
                'phone.*' => 'required|max:50',
                'button.*' => 'required|max:100',
                'image.*' => 'nullable|max:10240|image|mimes:jpg,jpeg,png,webp,svg',
            ]
        ],
        'preview' =>[
            'Dark Theme Image' => 'assets/preview/dark/social.png'
        ],
        'theme' => 'dark',
    ],
    'dark_buy_game_id' => [
        'single' => [
            'field_name' => [
                'title' => 'text',
                'sub_title' => 'text',
                'button' => 'text',
                'button_link' => 'url',
            ],
            'validation' => [
                'title.*' => 'required|max:100',
                'sub_title.*' => 'required|max:200',
                'button.*' => 'required|max:100',
                'button_link.*' => 'required|max:500',
            ]
        ],
        'preview' => [
            'Dark Theme Image' =>'assets/preview/dark/buy_game_id.png'
        ],
        'theme' => 'dark',
    ],

    'light_hero' => [
        'multiple' => [
            'field_name' => [
                'title' => 'text',
                'sub_title' => 'text',
                'description' => 'text',
                'button' => 'text',
                'button_link' => 'url',
                'image' => 'file',
                'image_two' => 'file',
                'image_three' => 'file',
            ],
            'validation' => [
                'title.*' => 'required|max:100',
                'sub_title.*' => 'required|max:200',
                'description.*' => 'required|max:500',
                'button.*' => 'required|max:100',
                'button_link.*' => 'required|max:200',
                'image.*' => 'nullable|max:10240|image|mimes:jpg,jpeg,png,webp,svg',
                'image_two.*' => 'nullable|max:10240|image|mimes:jpg,jpeg,png,webp,svg',
                'image_three.*' => 'nullable|max:10240|image|mimes:jpg,jpeg,png,webp,svg',
            ],
        ],
        'preview' => [
            'Light Theme Image' =>'assets/preview/light/hero.png'
        ],
        'theme' => 'light',
    ],
    'light_blog' => [
        'single' => [
            'field_name' => [
                'title' => 'text',
                'button' => 'text',
                'button_link' => 'url',
            ],
            'validation' => [
                'title.*' => 'required|max:100',
                'button.*' => 'required|max:100',
                'button_link.*' => 'required|max:100',
            ]
        ],
        'preview' =>[
            'Light Theme Image' => 'assets/preview/light/blog.png'
            ],
        'theme' => 'light',
    ],
    'light_testimonial' => [
        'single' => [
            'field_name' => [
                'title' => 'text',
                'sub_title' => 'text',
                'image' => 'file',
            ],
            'validation' => [
                'title.*' => 'required|max:100',
                'sub_title.*' => 'required|max:500',
                'image.*' => 'nullable|max:10240|image|mimes:jpg,jpeg,png,webp,svg',
            ]
        ],
        'multiple' => [
            'field_name' => [
                'name' => 'text',
                'location' => 'text',
                'review' => 'text',
                'rating' => 'text',
                'image' => 'file'
            ],
            'validation' => [
                'name.*' => 'required|max:100',
                'location.*' => 'required|max:100',
                'review.*' => 'required|max:1000',
                'rating.*' => 'required|max:100',
                'image.*' => 'nullable|max:10240|image|mimes:jpg,jpeg,png,webp,svg',
            ],
        ],
        'preview' =>[
            'Light Theme Image' => 'assets/preview/light/testimonial.png'
            ],
        'theme' => 'light',
    ],
    'light_why_chose_us' => [
        'single' => [
            'field_name' => [
                'title' => 'text',
                'sub_title' => 'text',
                'button' => 'text',
                'button_link' => 'url',
                'image' => 'file',
            ],
            'validation' => [
                'title.*' => 'required|max:100',
                'sub_title.*' => 'required|max:100',
                'button.*' => 'required|max:100',
                'button_link.*' => 'required|max:200',
                'image.*' => 'nullable|max:10240|image|mimes:jpg,jpeg,png,webp,svg',
            ]
        ],
        'multiple' => [
            'field_name' => [
                'title' => 'text',
                'description' => 'text',

            ],
            'validation' => [
                'title.*' => 'required|max:100',
                'description.*' => 'required|max:500',

            ],
        ],
        'preview' =>[
            'Light Theme Image' => 'assets/preview/light/why_chose_us.png'
        ],
        'theme' => 'light',
    ],
    'light_top_up' => [
        'single' => [
            'field_name' => [
                'title' => 'text',
                'sub_title' => 'text',
                'button' => 'text',
                'button_link' => 'url',
            ],
            'validation' => [
                'title.*' => 'required|max:100',
                'sub_title.*' => 'required|max:100',
                'button.*' => 'required|max:100',
                'button_link.*' => 'required|max:100',
            ]
        ],
        'preview' =>[
            'Light Theme Image' => 'assets/preview/light/top_up.png'
            ],
        'theme' => 'light',
    ],
    'light_campaign' => [
        'single' => [
            'field_name' => [
                'heading' => 'text',
                'title' => 'text',
                'sub_title' => 'text',
                'image' => 'file',
            ],
            'validation' => [
                'heading.*' => 'required|max:100',
                'title.*' => 'required|max:100',
                'sub_title.*' => 'required|max:100',
                'image.*' => 'nullable|max:10240|image|mimes:jpg,jpeg,png,webp,svg',
            ]
        ],
        'preview' =>[
            'Light Theme Image' => 'assets/preview/light/campaign.png'
            ],
        'theme' => 'light',
    ],
    'light_about' => [
        'single' => [
            'field_name' => [
                'title' => 'text',
                'description' => 'textarea',
                'button' => 'text',
                'button_link' => 'url',
                'image' => 'file',
            ],
            'validation' => [
                'title.*' => 'required|max:100',
                'description.*' => 'required|max:10050',
                'button.*' => 'required|max:100',
                'button_link.*' => 'required|max:100',
                'image.*' => 'nullable|max:10240|image|mimes:jpg,jpeg,png,webp,svg',
            ]
        ],
        'preview' =>[
            'Light Theme Image' => 'assets/preview/light/about.png'
            ],
        'theme' => 'light',
    ],
    'light_brand' => [
        'multiple' => [
            'field_name' => [
                'item' => 'text',
                'icon' => 'text',
            ],
            'validation' => [
                'item.*' => 'required|max:100',
                'icon.*' => 'required|max:200',
            ]
        ],
        'preview' =>[
            'Light Theme Image' => 'assets/preview/light/about.png'
            ],
        'theme' => 'light',
    ],
    'light_exclusive_card' => [
        'single' => [
            'field_name' => [
                'title' => 'text',
                'sub_title' => 'text',
                'button' => 'text',
                'button_link' => 'url',
            ],
            'validation' => [
                'title.*' => 'required|max:100',
                'sub_title.*' => 'required|max:200',
                'button.*' => 'required|max:100',
                'button_link.*' => 'required|max:100',

            ]
        ],
        'preview' =>[
            'Light Theme Image' => 'assets/preview/light/exclusive_card.png'
            ],
        'theme' => 'light',
    ],
    'light_trending_item' => [
        'single' => [
            'field_name' => [
                'title' => 'text',
                'sub_title' => 'text',
            ],
            'validation' => [
                'title.*' => 'required|max:100',
                'sub_title.*' => 'required|max:200',

            ]
        ],
        'preview' =>[
            'Light Theme Image' => 'assets/preview/light/trending_item.png'
            ],
        'theme' => 'light',
    ],
    'light_contact' => [
        'single' => [
            'field_name' => [
                'title' => 'text',
                'sub_title' => 'text',
                'form_title' => 'text',
                'form_sub_title' => 'text',
                'email' => 'text',
                'location' => 'text',
                'phone' => 'text',
                'button' => 'text',
            ],
            'validation' => [
                'title.*' => 'required|max:100',
                'sub_title.*' => 'required|max:200',
                'form_title.*' => 'required|max:100',
                'form_sub_title.*' => 'required|max:800',
                'email.*' => 'required|max:50',
                'location.*' => 'required|max:200',
                'phone.*' => 'required|max:50',
                'button.*' => 'required|max:100',
            ]
        ],
        'preview' =>[
            'Light Theme Image' => 'assets/preview/light/contact.png'
            ],
        'theme' => 'light',
    ],
    'light_buy_game_id' => [
        'single' => [
            'field_name' => [
                'title' => 'text',
                'sub_title' => 'text',
                'button' => 'text',
                'button_link' => 'url',
            ],
            'validation' => [
                'title.*' => 'required|max:100',
                'sub_title.*' => 'required|max:200',
                'button.*' => 'required|max:100',
                'button_link.*' => 'required|max:500',
            ]
        ],
        'preview' =>[
            'Light Theme Image' => 'assets/preview/light/buy_game_id.png'
            ],
        'theme' => 'light',
    ],

    'authentication' => [
        'single' => [
            'field_name' => [
                'login_page_heading' => 'text',
                'login_page_sub_heading' => 'text',
                'register_page_heading' => 'text',
                'register_page_sub_heading' => 'text',
                'image' => 'file',
            ],
            'validation' => [
                'login_page_heading.*' => 'required|max:300',
                'login_page_sub_heading.*' => 'required|max:500',
                'register_page_heading.*' => 'required|max:300',
                'register_page_sub_heading.*' => 'required|max:500',
                'image.*' => 'nullable|max:10240|image|mimes:jpg,jpeg,png,webp,svg',
            ],
            'size' => [
                'image' => '537x714'
            ],
        ],
        'preview' => [
            'Dark Theme Image' => 'assets/preview/dark/authentication.png',
            'Light Theme Image' => 'assets/preview/light/authentication.png',
        ],
        'theme' => 'all',
    ],

    'footer' => [
        'single' => [
            'field_name' => [
                'newsletter_text' => 'text',
                'newsletter_button' => 'text',
                'message' => 'text',
                'footer_email' => 'text',
                'footer_location' => 'text',
                'footer_phone' => 'text',
                'copyright_text_one' => 'text',
                'copyright_text_two' => 'text',
                'app_store_link' => 'text',
                'google_store_link' => 'text',
            ],
            'validation' => [
                'newsletter_text.*' => 'required|max:100',
                'newsletter_button.*' => 'required|max:100',
                'message.*' => 'required|max:500',
                'footer_email.*' => 'required|max:50',
                'footer_location.*' => 'required|max:200',
                'footer_phone.*' => 'required|max:50',
                'copyright_text_one.*' => 'required|max:200',
                'copyright_text_two.*' => 'required|max:200',
                'app_store_link.*' => 'nullable',
                'google_store_link.*' => 'nullable',
            ]
        ],
        'multiple' => [
            'field_name' => [
                'name' => 'text',
                'icon' => 'text',
                'my_link' => 'url',
            ],
            'validation' => [
                'name.*' => 'required|max:1000',
                'icon.*' => 'required|max:1000',
                'my_link.*' => 'required|url',
            ]
        ],
        'preview' => [
            'Dark Theme Image' => 'assets/preview/dark/footer.png',
            'Light Theme Image' => 'assets/preview/light/footer.png',
            ],
        'theme' => 'all',
    ],

    'social' => [
        'single' => [
            'field_name' => [
                'footer_email' => 'text',
                'footer_location' => 'text',
                'footer_phone' => 'text',
            ],
            'validation' => [
                'footer_email.*' => 'required|max:50',
                'footer_location.*' => 'required|max:200',
                'footer_phone.*' => 'required|max:50',
            ]
        ],
        'multiple' => [
            'field_name' => [
                'name' => 'text',
                'icon' => 'text',
                'my_link' => 'url',
            ],
            'validation' => [
                'name.*' => 'required|max:1000',
                'icon.*' => 'required|max:1000',
                'my_link.*' => 'required|url',
            ]
        ],
        'preview' => [
            'Dark Theme Image' => 'assets/preview/dark/social.png',
            'Light Theme Image' => 'assets/preview/light/social.png',
        ],

        'theme' => 'all',
    ],
    'app_page' => [
        'single' => [
            'field_name' => [
                'heading' => 'text',
                'sub_heading' => 'text',
                'button_name' => 'text',
                'image' => 'file',
            ],
            'validation' => [
                'heading.*' => 'required|max:500',
                'sub_heading.*' => 'required|max:300',
                'button_name.*' => 'required|max:50',
                'image.*' => 'nullable|max:10240|image|mimes:jpg,jpeg,png',
            ]
        ],
        'preview' => [
            'Preview Image' => 'assets/preview/dark/app.png',
        ],

        'theme' => 'all',
    ],

    'message' => [
        'required' => 'This field is required.',
        'min' => 'This field must be at least :min characters.',
        'max' => 'This field may not be greater than :max characters.',
        'image' => 'This field must be image.',
        'mimes' => 'This image must be a file of type: jpg, jpeg, png.',
        'integer' => 'This field must be an integer value',
    ],

    'content_media' => [
        'image' => 'file',
        'image_two' => 'file',
        'image_three' => 'file',
        'thumb_image' => 'file',
        'background_image' => 'file',
        'my_link' => 'url',
        'button_link' => 'url',
        'icon' => 'icon',
        'count_number' => 'number',
        'start_date' => 'date'
    ]
];


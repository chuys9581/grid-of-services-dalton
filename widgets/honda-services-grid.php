<?php
class Honda_Services_Grid extends \Elementor\Widget_Base {
    public function get_name() {
        return 'honda-services-grid';
    }

    public function get_title() {
        return __('Honda Services Grid', 'honda-services');
    }

    public function get_icon() {
        return 'eicon-grid-4';
    }

    public function get_categories() {
        return ['honda-widgets'];
    }

    protected function register_controls() {
        // Grid Items Section
        $this->start_controls_section(
            'section_grid',
            [
                'label' => __('Grid Items', 'honda-services'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'item_image',
            [
                'label' => __('Icon Image', 'honda-services'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'item_title',
            [
                'label' => __('Title', 'honda-services'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Service Title', 'honda-services'),
            ]
        );

        $repeater->add_control(
            'item_description',
            [
                'label' => __('Description', 'honda-services'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Service description goes here', 'honda-services'),
            ]
        );

        $repeater->add_control(
            'item_url',
            [
                'label' => __('URL', 'honda-services'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'honda-services'),
                'default' => [
                    'url' => '',
                    'is_external' => true,
                    'nofollow' => true,
                ],
            ]
        );

        $repeater->add_control(
            'title_color',
            [
                'label' => __('Title Color', 'honda-services'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#FF0000',
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .service-title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'grid_items',
            [
                'label' => __('Grid Items', 'honda-services'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'item_title' => 'HONDA FINANCE',
                        'item_description' => 'Conoce Honda Finance y comienza a darle forma a tus sueños.',
                    ],
                    // Add more default items as needed
                ],
                'title_field' => '{{{ item_title }}}',
            ]
        );

        $this->end_controls_section();

        // Social Media Section
        $this->start_controls_section(
            'section_social',
            [
                'label' => __('Social Media', 'honda-services'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'social_title',
            [
                'label' => __('Social Media Title', 'honda-services'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Síguenos', 'honda-services'),
            ]
        );

        $social_repeater = new \Elementor\Repeater();

        $social_repeater->add_control(
            'social_icon',
            [
                'label' => __('Icon', 'honda-services'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fab fa-facebook',
                    'library' => 'fa-brands',
                ],
            ]
        );

        $social_repeater->add_control(
            'social_url',
            [
                'label' => __('URL', 'honda-services'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'honda-services'),
            ]
        );

        $this->add_control(
            'social_items',
            [
                'label' => __('Social Media Links', 'honda-services'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $social_repeater->get_controls(),
                'default' => [
                    [
                        'social_icon' => [
                            'value' => 'fab fa-facebook',
                            'library' => 'fa-brands',
                        ],
                    ],
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="honda-services-grid">
            <div class="services-grid">
                <?php foreach ($settings['grid_items'] as $index => $item) : ?>
                    <div class="service-item elementor-repeater-item-<?php echo esc_attr($item['_id']); ?>">
                        <div class="service-icon">
                            <?php if (!empty($item['item_url']['url'])) : ?>
                                <a href="<?php echo esc_url($item['item_url']['url']); ?>" 
                                   <?php echo $item['item_url']['is_external'] ? 'target="_blank"' : ''; ?>
                                   <?php echo $item['item_url']['nofollow'] ? 'rel="nofollow"' : ''; ?>>
                            <?php endif; ?>
                            <?php if (!empty($item['item_image']['url'])) : ?>
                                <img src="<?php echo esc_url($item['item_image']['url']); ?>" alt="<?php echo esc_attr($item['item_title']); ?>">
                            <?php endif; ?>
                            <?php if (!empty($item['item_url']['url'])) : ?>
                                </a>
                            <?php endif; ?>
                        </div>
                        <h3 class="service-title"><?php echo esc_html($item['item_title']); ?></h3>
                        <p class="service-description"><?php echo esc_html($item['item_description']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="social-media-section">
                <h4 class="social-title"><?php echo esc_html($settings['social_title']); ?></h4>
                <div class="social-icons">
                    <?php foreach ($settings['social_items'] as $social) : ?>
                        <a href="<?php echo esc_url($social['social_url']['url']); ?>" class="social-icon" target="_blank">
                            <?php \Elementor\Icons_Manager::render_icon($social['social_icon'], ['aria-hidden' => 'true']); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <style>
            .honda-services-grid {
                width: 100%;
                max-width: 1200px;
                margin: 0 auto;
            }

            .services-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 20px;
                margin-bottom: 40px;
            }

            .service-item {
                background: #f5f5f5;
                padding: 20px;
                text-align: center;
                border-radius: 8px;
            }

            .service-icon {
                margin-bottom: 15px;
            }

            .service-icon img {
                width: 80px;
                height: auto;
            }

            .service-title {
                margin: 10px 0;
                font-size: 18px;
                font-weight: bold;
            }

            .service-description {
                font-size: 14px;
                line-height: 1.4;
                color: #666;
            }

            .social-media-section {
                text-align: center;
                margin-top: 40px;
            }

            .social-title {
                font-size: 24px;
                margin-bottom: 20px;
            }

            .social-icons {
                display: flex;
                justify-content: center;
                gap: 15px;
            }

            .social-icon {
                width: 40px;
                height: 40px;
                background: #fff;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                border: 1px solid #ddd;
                transition: all 0.3s ease;
            }

            .social-icon:hover {
                background: #f0f0f0;
            }

            .service-icon a {
                display: inline-block;
                transition: transform 0.3s ease;
            }

            .service-icon a:hover {
                transform: scale(1.05);
            }

            @media (max-width: 768px) {
                .services-grid {
                    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                }
            }
        </style>
        <?php
    }
}
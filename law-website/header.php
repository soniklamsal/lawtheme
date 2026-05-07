<?php
/**
 * The header template
 *
 * @package LawFirm_Pro
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">

    <?php wp_head(); ?>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#26cf71',
                        'primary-dark': '#1eb863',
                        'text-dark': '#1A2B3C',
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', '-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'Roboto', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/custom.css">
    
    <!-- Navbar Scroll Styles - Inline to ensure they always work -->
    <style>
    /* Navbar Scroll Behavior */
    .navbar-transparent {
        background: transparent !important;
        box-shadow: none !important;
    }
    
    .navbar-scrolled {
        background: rgba(255, 255, 255, 0.95) !important;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05) !important;
    }
    
    .navbar-transparent .site-title-text {
        background: none !important;
        -webkit-text-fill-color: #ffffff !important;
        color: #ffffff !important;
    }
    
    .navbar-scrolled .site-title-text {
        background: linear-gradient(135deg, #26cf71 0%, #1A2B3C 100%) !important;
        -webkit-background-clip: text !important;
        -webkit-text-fill-color: transparent !important;
        background-clip: text !important;
    }
    
    .navbar-transparent #nav-menu-wrapper ul li a {
        color: #ffffff !important;
    }
    
    .navbar-scrolled #nav-menu-wrapper ul li a {
        color: #333 !important;
    }
    
    .navbar-transparent #menu-toggle {
        color: #ffffff !important;
    }
    
    .navbar-scrolled #menu-toggle {
        color: #333 !important;
    }
    
    /* Hover effects */
    #nav-menu-wrapper ul li a:hover {
        color: #26cf71 !important;
        border-bottom-color: #26cf71 !important;
    }
    
    /* Mobile Menu Fixes - Always dark text on white background */
    @media (max-width: 768px) {
        #nav-menu-wrapper {
            background: white !important;
        }
        
        /* Force dark text on mobile menu - highest specificity */
        .navbar-transparent #nav-menu-wrapper ul li a,
        .navbar-scrolled #nav-menu-wrapper ul li a,
        #nav-menu-wrapper ul li a,
        #nav-menu-wrapper .nav-menu-items li a {
            color: #333 !important;
        }
        
        /* Ensure close button is always visible */
        #menu-close {
            color: #333 !important;
        }
        
        /* Override any inherited styles */
        #nav-menu-wrapper ul.nav-menu-items li a {
            color: #333 !important;
        }
        
        /* Force override with attribute selector */
        #nav-menu-wrapper a[href] {
            color: #333 !important;
        }
    }
    </style>
    
    <!-- Navbar Scroll Effect - Inline to ensure it always works -->
    <script>
    (function() {
        'use strict';
        
        function initNavbarScroll() {
            const header = document.getElementById('masthead');
            if (!header) return;
            
            // Detect if we're on homepage
            const isHomePage = document.body.classList.contains('home') || 
                              document.body.classList.contains('front-page') ||
                              document.body.classList.contains('page-template-default') ||
                              window.location.pathname === '/' ||
                              window.location.pathname === '/index.php' ||
                              window.location.href.indexOf('/?') !== -1;
            
            function updateNavbar() {
                const scrolled = window.pageYOffset > 50;
                
                if (isHomePage) {
                    if (scrolled) {
                        header.classList.add('navbar-scrolled');
                        header.classList.remove('navbar-transparent');
                    } else {
                        header.classList.remove('navbar-scrolled');
                        header.classList.add('navbar-transparent');
                    }
                } else {
                    header.classList.add('navbar-scrolled');
                    header.classList.remove('navbar-transparent');
                }
            }
            
            // Initial call
            updateNavbar();
            
            // Listen for scroll
            window.addEventListener('scroll', updateNavbar);
            window.addEventListener('load', updateNavbar);
            window.addEventListener('resize', updateNavbar);
        }
        
        // Initialize when DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initNavbarScroll);
        } else {
            initNavbarScroll();
        }
        
        // Fallback - initialize after a short delay
        setTimeout(initNavbarScroll, 100);
        
        // Mobile menu text color fix
        function fixMobileMenuColors() {
            const menuWrapper = document.getElementById('nav-menu-wrapper');
            const menuLinks = document.querySelectorAll('#nav-menu-wrapper a');
            
            if (menuWrapper && window.innerWidth <= 768) {
                menuLinks.forEach(function(link) {
                    link.style.color = '#333';
                });
            }
        }
        
        // Fix mobile menu colors when menu is opened
        const menuToggle = document.getElementById('menu-toggle');
        if (menuToggle) {
            menuToggle.addEventListener('click', function() {
                setTimeout(fixMobileMenuColors, 50);
            });
        }
        
        // Fix on window resize
        window.addEventListener('resize', fixMobileMenuColors);
        
        // Initial fix
        fixMobileMenuColors();
    })();
    </script>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">

<!-- ================= HEADER ================= -->
<header id="masthead"
    class="site-header fixed inset-x-0 top-0 z-[100] transition-all duration-300 bg-transparent">

    <nav class="h-[4.5rem] flex items-center justify-between px-6 max-w-6xl mx-auto">

        <!-- LOGO -->
        <div class="flex items-center">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="custom-logo-link flex flex-col items-center" id="site-logo-link">
                <?php
                if ( has_custom_logo() ) :
                    the_custom_logo();
                    ?>
                    <span class="site-title-text text-lg font-extrabold mt-1 transition-colors duration-300 text-white"><?php bloginfo( 'name' ); ?></span>
                    <?php
                else :
                    ?>
                    <span class="text-2xl font-bold transition-colors duration-300 text-white">
                        <?php bloginfo( 'name' ); ?>
                    </span>
                    <?php
                endif;
                ?>
            </a>
        </div>

        <!-- NAV MENU -->
        <div id="nav-menu-wrapper"
             class="flex gap-8 items-center md:flex-row md:static md:w-auto md:h-auto md:bg-transparent md:shadow-none md:p-0 fixed top-0 -right-full w-[70%] h-screen bg-white shadow-[-2px_0_16px_rgba(0,0,0,0.1)] p-8 pt-16 flex-col md:items-center items-start transition-[right] duration-[400ms]">

            <button id="menu-close"
                    class="absolute top-4 right-6 text-2xl text-[#333] cursor-pointer bg-transparent border-none md:hidden">
                ✕
            </button>

            <?php
            wp_nav_menu( array(
                'theme_location' => 'primary',
                'menu_class'     => 'flex gap-8 list-none md:flex-row flex-col md:gap-8 gap-6 nav-menu-items',
                'container'      => false,
                'fallback_cb'    => false,
                'items_wrap'     => '<ul class="%2$s">%3$s</ul>',
            ) );
            ?>

        </div>

        <!-- MOBILE TOGGLE -->
        <button id="menu-toggle"
                class="text-2xl cursor-pointer bg-transparent border-none md:hidden transition-colors duration-300 text-white">
            ☰
        </button>

    </nav>

</header>
<!-- ================= END HEADER ================= -->

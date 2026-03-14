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
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">

<!-- ================= HEADER ================= -->
<header id="masthead"
    class="site-header fixed inset-x-0 top-0 z-[100] transition-all duration-300 <?php echo is_front_page() ? 'bg-transparent' : 'bg-white/95 shadow-lg'; ?>">

    <nav class="h-[4.5rem] flex items-center justify-between px-6 max-w-6xl mx-auto">

        <!-- LOGO -->
        <div class="flex items-center">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="custom-logo-link flex flex-col items-center" id="site-logo-link">
                <?php
                if ( has_custom_logo() ) :
                    the_custom_logo();
                    ?>
                    <span class="site-title-text text-lg font-extrabold mt-1 transition-colors duration-300 <?php echo is_front_page() ? 'text-white' : 'text-text-dark'; ?>"><?php bloginfo( 'name' ); ?></span>
                    <?php
                else :
                    ?>
                    <span class="text-2xl font-bold transition-colors duration-300 <?php echo is_front_page() ? 'text-white' : 'text-text-dark'; ?>">
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
                class="text-2xl cursor-pointer bg-transparent border-none md:hidden transition-colors duration-300 <?php echo is_front_page() ? 'text-white' : 'text-[#333]'; ?>">
            ☰
        </button>

    </nav>

</header>
<!-- ================= END HEADER ================= -->

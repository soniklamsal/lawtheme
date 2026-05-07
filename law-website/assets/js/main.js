/**
 * Main JavaScript for LawFirm Pro
 * @package LawFirm_Pro
 */

(function() {
    'use strict';
    
    // Wait for DOM to be ready
    document.addEventListener('DOMContentLoaded', function() {
        
        // Mobile menu toggle
        const menuToggle = document.getElementById('menu-toggle');
        const menuClose = document.getElementById('menu-close');
        const navMenuWrapper = document.getElementById('nav-menu-wrapper');
        
        if (menuToggle && navMenuWrapper) {
            menuToggle.addEventListener('click', function() {
                navMenuWrapper.style.right = '0';
            });
        }
        
        if (menuClose && navMenuWrapper) {
            menuClose.addEventListener('click', function() {
                navMenuWrapper.style.right = '-100%';
            });
        }
        
        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            if (navMenuWrapper && !navMenuWrapper.contains(e.target) && !menuToggle.contains(e.target)) {
                if (navMenuWrapper.style.right === '0px') {
                    navMenuWrapper.style.right = '-100%';
                }
            }
        });
        
        // Drag to scroll functionality
        setupDragScroll('category-scroll');
        setupDragScroll('featured-services-scroll');
        setupDragScroll('popular-services-scroll');
        
        // Scroll buttons for featured services
        const scrollLeftBtn = document.getElementById('scroll-left-featured');
        const scrollRightBtn = document.getElementById('scroll-right-featured');
        const featuredContainer = document.getElementById('featured-services-scroll');
        
        if (scrollLeftBtn && featuredContainer) {
            scrollLeftBtn.addEventListener('click', () => {
                featuredContainer.scrollBy({ left: -350, behavior: 'smooth' });
            });
        }
        
        if (scrollRightBtn && featuredContainer) {
            scrollRightBtn.addEventListener('click', () => {
                featuredContainer.scrollBy({ left: 350, behavior: 'smooth' });
            });
        }
        
        // Scroll buttons for popular services
        const scrollLeftPopular = document.getElementById('scroll-left-popular');
        const scrollRightPopular = document.getElementById('scroll-right-popular');
        const popularContainer = document.getElementById('popular-services-scroll');
        
        if (scrollLeftPopular && popularContainer) {
            scrollLeftPopular.addEventListener('click', () => {
                popularContainer.scrollBy({ left: -350, behavior: 'smooth' });
            });
        }
        
        if (scrollRightPopular && popularContainer) {
            scrollRightPopular.addEventListener('click', () => {
                popularContainer.scrollBy({ left: 350, behavior: 'smooth' });
            });
        }
        
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                if (href !== '#' && href.length > 1) {
                    const target = document.querySelector(href);
                    if (target) {
                        e.preventDefault();
                        const headerOffset = 80;
                        const elementPosition = target.getBoundingClientRect().top;
                        const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
                        
                        window.scrollTo({
                            top: offsetPosition,
                            behavior: 'smooth'
                        });
                        
                        // Close mobile menu after clicking link
                        if (navMenuWrapper) {
                            navMenuWrapper.style.right = '-100%';
                        }
                    }
                }
            });
        });
        
        // Header scroll effect (works on all pages)
        const header = document.getElementById('masthead');
        const isHomePage = document.body.classList.contains('home') || 
                          document.body.classList.contains('front-page') || 
                          window.location.pathname === '/';
        
        if (header) {
            // Function to update header based on scroll
            function updateHeader() {
                const scrolled = window.pageYOffset > 50;
                
                if (isHomePage) {
                    // Homepage: transparent to white
                    if (scrolled) {
                        header.classList.add('navbar-scrolled');
                        header.classList.remove('navbar-transparent');
                    } else {
                        header.classList.remove('navbar-scrolled');
                        header.classList.add('navbar-transparent');
                    }
                } else {
                    // Other pages: always white
                    header.classList.add('navbar-scrolled');
                    header.classList.remove('navbar-transparent');
                }
            }
            
            // Initial setup
            updateHeader();
            
            // Listen for scroll events
            window.addEventListener('scroll', updateHeader);
            
            // Also listen for page load to ensure proper state
            window.addEventListener('load', updateHeader);
        }
    });
    
    // Setup drag to scroll
    function setupDragScroll(elementId) {
        const container = document.getElementById(elementId);
        if (!container) return;
        
        let isDragging = false;
        let startX;
        let scrollLeft;
        
        container.addEventListener('mousedown', function(e) {
            isDragging = true;
            container.style.cursor = 'grabbing';
            startX = e.pageX - container.offsetLeft;
            scrollLeft = container.scrollLeft;
        });
        
        container.addEventListener('mousemove', function(e) {
            if (!isDragging) return;
            e.preventDefault();
            const x = e.pageX - container.offsetLeft;
            const walk = (x - startX) * 2;
            container.scrollLeft = scrollLeft - walk;
        });
        
        container.addEventListener('mouseup', function() {
            isDragging = false;
            container.style.cursor = 'grab';
        });
        
        container.addEventListener('mouseleave', function() {
            isDragging = false;
            container.style.cursor = 'grab';
        });
    }
    
})();

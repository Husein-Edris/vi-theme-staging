/**
 * Mobile Menu Back Button
 */

jQuery(document).ready(function($) {
    
    // EVERYTHING COMMENTED OUT FOR TESTING
    /*
    
    // Add unified back buttons to all submenu levels
    function addMobileMenuBackButtons() {
        $('#slide-out-widget-area .off-canvas-menu-container ul.sub-menu, .menu.menuopen .sub-menu').each(function() {
            var $submenu = $(this);
            $submenu.find('li.back').remove();
            $submenu.prepend('<li class="back"><a href="#"> Back </a></li>');
        });
    }
    
    // Handle back button clicks with animation
    function handleBackButtonClicks() {
        $(document).on('click', '.sub-menu li.back a', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            var $backLink = $(this);
            var $currentSubmenu = $backLink.closest('.sub-menu');
            var $parentMenuItem = $currentSubmenu.parent('li.menu-item-has-children');
            var $parentMenu = $parentMenuItem.parent('ul');
            
            $parentMenu.addClass('dl-animate-out-5');
            
            setTimeout(function() {
                $parentMenu.removeClass('subview dl-animate-out-5').addClass('dl-animate-in-5');
                $parentMenuItem.removeClass('subviewopen current-menu-item current-menu-ancestor current-menu-parent');
                
                setTimeout(function() {
                    $parentMenu.removeClass('dl-animate-in-5');
                }, 250);
                
            }, 250);
        });
    }
    
    // Handle submenu navigation with animation (mobile only)
    function handleSubmenuNavigation() {
        $(document).on('click', '.menu-item-has-children > a', function(e) {
            var $link = $(this);
            var $parentItem = $link.parent('li');
            var $submenu = $parentItem.find('> .sub-menu');
            var $parentMenu = $parentItem.parent('ul');
            
            // Only handle if we're in mobile menu context
            var isMobileMenu = $link.closest('#slide-out-widget-area').length > 0 || 
                              $link.closest('.menu.menuopen').length > 0;
            
            if ($submenu.length > 0 && isMobileMenu) {
                e.preventDefault();
                e.stopPropagation();
                
                $parentMenu.addClass('dl-animate-out-5');
                
                setTimeout(function() {
                    $parentMenu.removeClass('dl-animate-out-5').addClass('subview dl-animate-in-5');
                    $parentItem.addClass('subviewopen current-menu-item');
                    
                    setTimeout(function() {
                        $parentMenu.removeClass('dl-animate-in-5');
                    }, 250);
                    
                }, 250);
            }
        });
    }
    
    // Remove Skip to Main Content elements from parent theme
    function removeSkipToMainContent() {
        // Remove by class
        $('.nectar-skip-to-content').remove();
        
        // Remove by text content as fallback
        $('a').each(function() {
            if ($(this).text().trim() === 'Skip to main content' || $(this).text().trim() === 'Skip to Main Content') {
                $(this).remove();
            }
        });
    }
    
    // Initialize mobile menu functionality
    function initMobileMenuFix() {
        addMobileMenuBackButtons();
        handleBackButtonClicks();
        handleSubmenuNavigation();
        removeSkipToMainContent();
    }
    
    // Initialize on page load
    initMobileMenuFix();
    
    // Re-initialize when mobile menu is opened
    $(document).on('click', '.slide-out-widget-area-toggle', function() {
        setTimeout(function() {
            addMobileMenuBackButtons();
            removeSkipToMainContent();
        }, 200);
    });
    
    $(document).ready(function() {
        setTimeout(function() {
            addMobileMenuBackButtons();
            removeSkipToMainContent();
        }, 500);
    });
    
    $(window).on('load', function() {
        setTimeout(function() {
            addMobileMenuBackButtons();
            removeSkipToMainContent();
        }, 1000);
    });
    
    */
    
});
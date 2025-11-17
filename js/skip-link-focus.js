/**
 * Skip Link Focus Fix for Accessibility
 * Ensures the skip link receives focus first during normal keyboard navigation
 * and properly handles focus management when activated
 */
document.addEventListener('DOMContentLoaded', function() {
    const skipLink = document.querySelector('.skip-to-login');
    
    if (skipLink) {
        // Handle skip link activation
        skipLink.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Find the target element (Login/Signup button)
            const targetElement = document.querySelector('#menu-item-5556 a');
            
            if (targetElement) {
                // Scroll to the target element
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
                
                // Focus the target element
                setTimeout(function() {
                    // Make the target focusable
                    const originalTabIndex = targetElement.getAttribute('tabindex');
                    targetElement.setAttribute('tabindex', '-1');
                    targetElement.focus();
                    
                    // Add visual focus indicator
                    targetElement.style.outline = '3px solid #f89122';
                    targetElement.style.outlineOffset = '2px';
                    
                    // Clean up when focus moves away
                    const cleanup = function() {
                        targetElement.style.outline = '';
                        targetElement.style.outlineOffset = '';
                        if (originalTabIndex === null) {
                            targetElement.removeAttribute('tabindex');
                        } else {
                            targetElement.setAttribute('tabindex', originalTabIndex);
                        }
                        targetElement.removeEventListener('blur', cleanup);
                    };
                    
                    targetElement.addEventListener('blur', cleanup);
                }, 300);
            }
        });
        
        // Handle keyboard activation
        skipLink.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                this.click();
            }
        });
    }
});
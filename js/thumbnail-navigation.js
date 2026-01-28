

(function($) {
    'use strict';
    
    $(document).ready(function() {
        

        function moveNavigationButtons() {
            var $navButtons = $('.wc-block-next-previous-buttons');
            
            var $thumbnailSection = $('.wc-block-product-gallery-thumbnails');
            
            if ($navButtons.length && $thumbnailSection.length) {
                var $prevButton = $navButtons.find('button').eq(0).clone();
                var $nextButton = $navButtons.find('button').eq(1).clone();
                
                $navButtons.hide();
                
                var $buttonWrapper = $('<div class="thumbnail-nav-buttons"></div>');
                
                $prevButton.addClass('thumbnail-nav-button thumbnail-nav-up');
                $nextButton.addClass('thumbnail-nav-button thumbnail-nav-down');
                
                $prevButton.on('click', function() {
                    scrollThumbnails('up');
                });
                
                $nextButton.on('click', function() {
                    scrollThumbnails('down');
                });
                
                $thumbnailSection.css('position', 'relative');
                $prevButton.css({
                    'position': 'absolute',
                    'top': '-50px',
                    'left': '50%',
                    'transform': 'translateX(-50%)'
                });
                $nextButton.css({
                    'position': 'absolute',
                    'bottom': '-50px',
                    'left': '50%',
                    'transform': 'translateX(-50%)'
                });
                
                $thumbnailSection.append($prevButton);
                $thumbnailSection.append($nextButton);
                
                $prevButton.find('svg').css('transform', 'rotate(90deg)');
                $nextButton.find('svg').css('transform', 'rotate(90deg)');
            }
        }

        function scrollThumbnails(direction) {
            var $scrollable = $('.wc-block-product-gallery-thumbnails__scrollable');
            var $thumbnails = $('.wc-block-product-gallery-thumbnails__thumbnail');
            
            if ($thumbnails.length === 0) return;
            
            var thumbnailHeight = $thumbnails.first().outerHeight(true);
            var currentScroll = $scrollable.scrollTop();
            
            if (direction === 'up') {
                $scrollable.animate({
                    scrollTop: currentScroll - thumbnailHeight
                }, 300);
                

                triggerPreviousImage();
            } else {
                $scrollable.animate({
                    scrollTop: currentScroll + thumbnailHeight
                }, 300);
                

                triggerNextImage();
            }
        }

        function triggerPreviousImage() {
            var $activeThumbnail = $('.wc-block-product-gallery-thumbnails__thumbnail__image--is-active');
            var $prevThumbnail = $activeThumbnail.closest('.wc-block-product-gallery-thumbnails__thumbnail').prev();
            
            if ($prevThumbnail.length) {
                $prevThumbnail.find('img').click();
            }
        }

        function triggerNextImage() {
            var $activeThumbnail = $('.wc-block-product-gallery-thumbnails__thumbnail__image--is-active');
            var $nextThumbnail = $activeThumbnail.closest('.wc-block-product-gallery-thumbnails__thumbnail').next();
            
            if ($nextThumbnail.length) {
                $nextThumbnail.find('img').click();
            }
        }
        

        function createThumbnailNavigationButtons() {
            var $thumbnailSection = $('.wc-block-product-gallery-thumbnails');
            
            if ($thumbnailSection.length === 0) return;
            

            $('.wc-block-next-previous-buttons').hide();
            

            var $upButton = $('<button>', {
                'class': 'thumbnail-nav-button thumbnail-nav-up',
                'aria-label': 'Previous image',
                'html': `
                    <svg xmlns="http://www.w3.org/2000/svg" width="8" height="12" fill="none">
                        <path fill="currentColor" fill-rule="evenodd" d="M6.445 12.005.986 6 6.445-.005l1.11 1.01L3.014 6l4.54 4.995-1.109 1.01Z" clip-rule="evenodd"/>
                    </svg>
                `
            });

            var $downButton = $('<button>', {
                'class': 'thumbnail-nav-button thumbnail-nav-down',
                'aria-label': 'Next image',
                'html': `
                    <svg xmlns="http://www.w3.org/2000/svg" width="8" height="12" fill="none">
                        <path fill="currentColor" fill-rule="evenodd" d="M1.555-.004 7.014 6l-5.459 6.005-1.11-1.01L4.986 6 .446 1.005l1.109-1.01Z" clip-rule="evenodd"/>
                    </svg>
                `
            });
            

            $upButton.on('click', function(e) {
                e.preventDefault();
                scrollThumbnails('up');
            });
            
            $downButton.on('click', function(e) {
                e.preventDefault();
                scrollThumbnails('down');
            });
            
            var buttonStyles = {
                'position': 'absolute',
                'left': '50%',
                'transform': 'translateX(-50%)',
                'width': '40px',
                'height': '40px',
                'background-color': 'white',
                'border': '2px solid #e5e5e5',
                'border-radius': '50%',
                'cursor': 'pointer',
                'display': 'flex',
                'align-items': 'center',
                'justify-content': 'center',
                'z-index': '10',
                'transition': 'all 0.3s ease',
                'box-shadow': '0 2px 8px rgba(0,0,0,0.1)'
            };
            
            $upButton.css({...buttonStyles, 'top': '-50px'});
            $downButton.css({...buttonStyles, 'bottom': '-50px'});
            
            $upButton.find('svg').css('transform', 'rotate(90deg)');
            $downButton.find('svg').css('transform', 'rotate(90deg)');
            
            $upButton.add($downButton).hover(
                function() {
                    $(this).css({
                        'background-color': '#4a3b6b',
                        'border-color': '#4a3b6b'
                    });
                    $(this).find('path').css('fill', 'white');
                },
                function() {
                    $(this).css({
                        'background-color': 'white',
                        'border-color': '#e5e5e5'
                    });
                    $(this).find('path').css('fill', 'currentColor');
                }
            );
            
            $thumbnailSection.css('position', 'relative');
            
            $thumbnailSection.append($upButton);
            $thumbnailSection.append($downButton);
        }
        
        setTimeout(function() {
            createThumbnailNavigationButtons();
        }, 500);
        
        $(document.body).on('wc_gallery_init', function() {
            setTimeout(function() {
                createThumbnailNavigationButtons();
            }, 100);
        });
        
    });
    
})(jQuery);

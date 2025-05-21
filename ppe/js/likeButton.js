document.addEventListener('DOMContentLoaded', function() {
    const likeButton = document.querySelector('.like-button');
    if (likeButton) {
        likeButton.addEventListener('click', function() {
            const icon = this.querySelector('ion-icon');
            if (icon) {
                icon.classList.toggle('active');
                // Animation du cœur
                if (icon.classList.contains('active')) {
                    icon.style.color = '#ff0000';
                    icon.style.transform = 'scale(1.2)';
                } else {
                    icon.style.color = 'white';
                    icon.style.transform = 'scale(1)';
                }
            }
        });
    }
});
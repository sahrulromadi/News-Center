
document.addEventListener('DOMContentLoaded', function() {
    updateVisibleItems();

    document.getElementById('scrollLeft').addEventListener('click', function() {
        document.querySelector('.scroll-content').scrollBy({
            left: -100,
            behavior: 'smooth'
        });
    });

    document.getElementById('scrollRight').addEventListener('click', function() {
        document.querySelector('.scroll-content').scrollBy({
            left: 100,
            behavior: 'smooth'
        });
    });
});

window.addEventListener('resize', function() {
    updateVisibleItems();
});

function updateVisibleItems() {
    const width = window.innerWidth;
    const items = document.querySelectorAll('.navbar-nav .nav-item');
    
    if (width <= 576) {
        items.forEach((item, index) => {
            item.style.display = index < 50 ? 'block' : 'none';
        });
    } else {
        items.forEach(item => {
            item.style.display = 'block';
        });
    }
}

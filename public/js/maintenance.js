document.addEventListener('DOMContentLoaded', function () {

    window.viewImage = function (imageUrl) {
        const modal = document.getElementById('imageModal');
        const image = document.getElementById('modalImage');

        if (!modal || !image) return;

        image.src = imageUrl;
        modal.style.display = 'flex';
    };

    window.closeImageModal = function () {
        const modal = document.getElementById('imageModal');
        if (!modal) return;

        modal.style.display = 'none';
    };

    const modal = document.getElementById('imageModal');
    if (modal) {
        modal.addEventListener('click', function (e) {
            if (e.target === modal) {
                window.closeImageModal();
            }
        });
    }

});

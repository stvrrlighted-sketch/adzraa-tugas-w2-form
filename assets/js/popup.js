(function () {
    var popup = document.getElementById('popup');
    if (!popup) {
        return;
    }

    var durasi = parseInt(popup.getAttribute('data-durasi'), 10) || 10000;
    var tombol = popup.querySelectorAll('button');
    var pewaktu = setTimeout(tutup, durasi);

    function tutup() {
        clearTimeout(pewaktu);
        document.removeEventListener('keydown', saatTombolDitekan);
        popup.hidden = true;
    }

    function saatTombolDitekan(event) {
        if (event.key === 'Escape') {
            tutup();
            return;
        }
        if (event.key !== 'Tab' || tombol.length === 0) {
            return;
        }

        var pertama = tombol[0];
        var terakhir = tombol[tombol.length - 1];
        if (event.shiftKey && document.activeElement === pertama) {
            event.preventDefault();
            terakhir.focus();
        } else if (!event.shiftKey && document.activeElement === terakhir) {
            event.preventDefault();
            pertama.focus();
        }
    }

    popup.addEventListener('click', function (event) {
        if (event.target === popup || event.target.closest('[data-tutup]')) {
            tutup();
        }
    });

    document.addEventListener('keydown', saatTombolDitekan);
    tombol[tombol.length - 1].focus();
})();

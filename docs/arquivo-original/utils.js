function openService(evt, service) {
    var i, tabcontent, tablinks;

    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
        tabcontent[i].classList.remove('fade-in', 'show');  // Remove classes de animação ao fechar
    }

    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    
    var selectedTab = document.getElementById(service);
    selectedTab.style.display = "block";
    
    // Adiciona a classe 'fade-in' para iniciar o efeito de fade
    selectedTab.classList.add('fade-in');

    // Adiciona a classe 'show' após um pequeno delay para aplicar o fade-in
    setTimeout(function() {
        selectedTab.classList.add('show');
    }, 100);

    evt.currentTarget.className += " active";    
}

$(document).ready(function() {
    // Clique no botão padrão para abrir a primeira aba
    document.getElementById("defaultOpen").click();

    var altura = $(window).height();    
    var meiaAltura = altura / 2;
    var height_nav = $('.header').height();

    $('.home').css("height", height_nav);

    $(document).on('click', 'a.nav-link', function(event) {
        var $anchor = $(this);
        var href = $anchor.attr('href')
        if (href.indexOf('#') != -1) {
            event.preventDefault();
            $('.navbar-collapse').toggleClass('show');
            $('.navbar-toggler').toggleClass('collapsed');
            $('html, body').stop().animate({
                scrollTop: $($anchor.attr('href')).offset().top - $('.header').outerHeight(true) - 80
            }, 800);
        }
    });

    $(document).on('click', 'a.nav-link-first', function(event) {
        var $anchor = $(this);
        var href = $anchor.attr('href')
        if (href.indexOf('#') != -1) {
            event.preventDefault();
            $('html, body').stop().animate({
                scrollTop: $($anchor.attr('href')).offset().top - $('.header').outerHeight(true) - 0
            }, 800);
        }
    });

    $(".navbar-nav .nav-link").on("click", function() {
        $(".navbar-nav").find(".active").removeClass("active");
        $(this).addClass("active");
    });

    $('.carousel').carousel({ interval: 2000 });
});

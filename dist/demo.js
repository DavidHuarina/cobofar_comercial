new Mmenu(
                document.querySelector('#menu'),
                {
                    extensions: ['theme-dark', 'shadow-page'],
                    setSelected: true,
                    counters: true,
                    searchfield: {
                        placeholder: 'Buscar',
                    },
                    iconbar: {
                        use: '(min-width: 450px)',
                        top: [
                            '<a href="#/"><span class="fa fa-angle-right"></span></a>',
                            
                        ],
                    },
                    sidebar: {
                        collapsed: {
                            use: '(min-width: 450px)',
                            hideNavbar: false,
                        },
                        expanded: {
                            use: '(min-width: 992px)',
                        },
                    },
                    navbars: [
                        {
                            content: ['searchfield'],
                        },
                        {
                            type: 'tabs',
                            content: [
                                '<a href="#panel-menu"><span>OPCIONES</span></a>','breadcrumbs', 'close'
                                
                            ],
                        },
                        {
                            position: 'bottom',
                            content: [
                                '<a href="http://farmaciasbolivia.com.bo" target="_blank">Farmacias Bolivia - Comercial</a>',
                            ],
                        },
                    ],
                },
                {
                    searchfield: {
                        clear: true,
                    },
                    navbars: {
                        breadcrumbs: {
                            removeFirst: true,
                        },
                    },
                }
            );

            document.addEventListener('click', function (evnt) {
                var anchor = evnt.target.closest('a[href^="#/"]');
                if (anchor) {
                    //alert("Thank you for clicking, but that's a demo link.");
                    evnt.preventDefault();
                }
            });
$(document).ready(function(){
      var height = $(window).height();
      $('.content').height(height);
});

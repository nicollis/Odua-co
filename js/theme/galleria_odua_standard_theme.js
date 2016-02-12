Galleria.addTheme({
    name: 'odua standard theme',
    author: 'Nicholas Gillespie, http://nic.odua.co',
    version: 1,
    css: 'gallera.odua_standard_theme.css',
    defaults: {
        transition: 'fade',
        imagecrop: true,
        _background_image: 'url(img/background.png)',
    },
    init: function(options){
        // set the container's background to the theme-specific _my_color option:
        this.$('container').css('background-image', options._background_image);

        // bind a loader animation:
        this.bind('loadstart', function(e) {
            if (!e.cached) {
                this.$('loader').show();
            }
        });
        this.bind('loadfinish', function(e) {
            this.$('loader').hide();
        });
    }
});
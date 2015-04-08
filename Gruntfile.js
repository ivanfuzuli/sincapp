module.exports = function(grunt) {

  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    concat: {
      options: {
        separator: ';'
      },
      dist: {
        src: ['files/home/js/modernizr.custom.53451.js', 'files/home/js/jquery.placeholder.js'
        , 'files/home/js/jquery.sticky.js', 'files/home/js/jquery.scrollTo.js'
        , 'files/home/js/jquery.nav.js', 'files/home/js/jquery.isotope.js', 'files/home/js/jquery.parallax-1.1.3.js'
        , 'files/home/js/jquery.localscroll-1.2.7-min.js', 'files/home/js/jquery.3dgallery.js', 'files/home/js/jquery.bxslider.js'
        , 'files/home/js/jquery.easing.min.js', 'files/home/js/responsiveslides.min.js',  'files/home/js/jquery.magnific-popup.js', 'files/home/js/jquery.fitvids.js'
        , 'files/home/js/gmap3.js', 'files/home/js/main_home.js', 'files/home/js/project_script.js', 'files/home/js/jquery.validate.min.js'
        , 'files/home/js/script_mail.js', 'files/home/js/animation.js', 'files/home/js/script_general.js'],
        dest: 'files/home/js/home.min.js'
      }
    },
    cssjoin: {
      editor :{
        files: {
          'files/css/build/editor.production.css': ['files/css/build/editor.development.css'],
        }
      },
      general: {
        files: {
          'files/css/build/general.production.css': ['files/css/build/general.development.css'],
        }
      },
      index: {
        files: {
          'files/css/build/index.production.css': ['files/css/build/index.development.css'],
        }
      }      
    },
    requirejs: {
      home: {
        options: {
          baseUrl: "files/js/app",
          mainConfigFile: "files/js/app/home.development.js",
          name: "home.development", // assumes a production build using almond
          out: "files/js/app/home.production.js"
        }
      },
      main: {
        options: {
          baseUrl: "files/js/app",
          mainConfigFile: "files/js/app/main.development.js",
          name: "main.development", // assumes a production build using almond
          out: "files/js/app/main.production.js"
        }
      },
      site: {
        options: {
          baseUrl: "files/js/app",
          mainConfigFile: "files/js/app/site.development.js",
          name: "site.development", // assumes a production build using almond
          out: "files/js/app/site.production.js"
        }
      }            
    },
    uglify: {
      options: {
        banner: '/*! <%= pkg.name %> <%= grunt.template.today("dd-mm-yyyy") %> */\n'
      },
      dist: {
        files: {
          'files/home/js/home.min.js': ['files/home/js/home.min.js'],
          'files/home/js/jquery-1.10.2.min.js': ['files/home/js/jquery-1.10.2.js']
        }
      }
    },
    jshint: {
      files: ['Gruntfile.js', 'files/home/js/*.js'],
      options: {
        // options here to override JSHint defaults
        globals: {
          jQuery: true,
          console: true,
          module: true,
          document: true
        }
      }
    }, 
    cssmin: {
      minify: {
        files: [{
          expand: true,
          cwd: 'files/home/css/',
          src: ['home.css'],
          dest: 'files/home/css/',
          ext: '.min.css'
        }, {
          expand: true,
          cwd: 'files/css/build/',
          src: ['editor.production.css'],
          dest: 'files/css/build/',
          ext: '.production.css'
        }, {
          expand: true,
          cwd: 'files/css/build/',
          src: ['index.production.css'],
          dest: 'files/css/build/',
          ext: '.production.css'
        }, {
          expand: true,
          cwd: 'files/css/build/',
          src: ['general.production.css'],
          dest: 'files/css/build/',
          ext: '.production.css'
        }
        ]
      }
    },    
    concat_css: {
      options: {},
      all: {
        src: ['files/home/css/bootstrap.css', 'files/home/css/bootstrap-responsive.css',
      'files/home/css/font-awesome.css', 'files/home/css/folio-font.css', 'files/home/css/style.css',
      'files/home/css/project_style.css', 'files/home/css/magnific-popup.css', 'files/home/css/isotope_animation.css', 'files/home/css/animation.css',
      'files/home/css/jquery.bxslider.css', 'files/home/css/responsiveslides.css', 'files/home/css/colors/orange.css'],
        dest: "files/home/css/home.css"
      },
    },    
    watch: {
      files: ['<%= jshint.files %>'],
      tasks: ['concat', 'concat_css', 'uglify']
    }
  });

  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-concat-css');
  grunt.loadNpmTasks('grunt-contrib-cssmin');
  grunt.loadNpmTasks('grunt-contrib-requirejs');
  grunt.loadNpmTasks('grunt-cssjoin');

  grunt.registerTask('test', ['jshint']);
  grunt.registerTask('home', ['cssjoin', 'concat', 'requirejs', 'concat_css', 'cssmin', 'uglify']);

  grunt.registerTask('default', ['cssjoin', 'requirejs', 'cssmin']);

};
/*global module:false*/
module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({
    meta: {
      version: '0.1.0',
      banner: '/*! Flight Apps - v<%= meta.version %> - ' +
        '<%= grunt.template.today("yyyy-mm-dd") %>\n' +
        '* http://booj.com/\n' +
        '* Copyright (c) <%= grunt.template.today("yyyy") %> ' +
        'Booj dba Active Website LLC.; Licensed MIT */'
    },

    lint: {
      files: ['grunt.js', 'public_html/js/*.js']
    },

    min: {
      dist: {
        src: [
          'public_html/js/lib/jquery.js',
          'public_html/js/lib/mustache.js',
          'vendor/bootstrap-3/js/collapse.js', 
          'vendor/bootstrap-3/js/carousel.js',
          'vendor/bootstrap-3/js/transition.js', 
          'vendor/bootstrap-3/js/modal.js', 
          'public_html/js/hover_intent.js', 
          'public_html/js/jquery.menu.js', 
          'public_html/js/application.js',
          'public_html/js/carousel.js'
        ],
        dest: 'public_html/dist/app.min.js'
      },
      distB: {
        src: [
          'public_html/js/homepage.js'
        ],
        dest: 'public_html/dist/homepage.min.js'
      }
    },

    less: {
      yuicompress: {
        options: {
          yuicompress: true
        },
        files: {
          'public_html/dist/style.min.css': ['application/less/style.less']
        }
      }
    },

    watch: {
      less: {
        files: 'application/less/**.less',
        tasks: ['less'],
        options: {
          interrupt: true
        }
      },
      scripts: {
        files: 'public_html/js/**.js',
        tasks: ['lint', 'min'],
        options: {
          interrupt: true
        }
      }
    },

    jshint: {
      options: {
        validthis: true,
        laxcomma : true,
        laxbreak : true,
        browser  : true,
        eqnull   : true,
        debug    : true,
        devel    : true,
        boss     : true,
        expr     : true,
        asi      : true
      },
      globals: {
        jQuery: true,
        google: true
      }
    }

  });

  // Default task.
  grunt.registerTask('default', 'lint less min');
  grunt.loadNpmTasks('grunt-contrib');
};

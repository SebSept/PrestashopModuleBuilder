// Project configuration
module.exports = function(grunt) {

grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    // uglify: {
    //   options: {
    //     banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n'
    //   },
    //   build: {
    //     src: 'src/<%= pkg.name %>.js',
    //     dest: 'build/<%= pkg.name %>.min.js'
    //   }
    // },
    cssmin: {
      minify: {
        report: 'min',
        expand: true,
        cwd: 'src/css/',
        src: ['*.css', '!*.min.css'],
        dest: 'src/css/min/',
        ext: '.css'
      }
    },
    concat: {
      options: {
        banner: '/* generated <%= grunt.template.today("yyyy-mm-dd") %> */'
      },
      dist: {
        src: ['src/css/min/fshl.css', 'src/css/min/pure.css'],
        dest: 'web/css/main.css'
      }
    }

  });

  // Load the plugin that provides the "uglify" task.
  grunt.loadNpmTasks('grunt-contrib-cssmin');
  grunt.loadNpmTasks('grunt-contrib-concat');

  // Default task(s).
  grunt.registerTask('default', ['cssmin', 'concat']);

};
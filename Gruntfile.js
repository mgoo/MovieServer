/**
 * Created by mgoo on 1/03/17.
 */
module.exports = function(grunt) {
    require('load-grunt-tasks')(grunt);


    grunt.initConfig({
        less: {
            development: {
                options: {
                    strictMath: true,
                    paths: ['webroot/css/less'],
                    compress: true
                },
                files: {
                    'webroot/css/styles.css': 'webroot/css/less/styles.less',
                }
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.registerTask('default', ['less']);
};
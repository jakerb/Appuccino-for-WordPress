
/**
 * Provide some Javascript to be included within your application.
 *
 * @link       https://github.com/jakerb/Appuccino-for-WordPress
 * @since      1.0.0
 *
 * @package    Appuccino
 */

 (function() {

 	if(typeof $appuccino !== 'undefined') {

 		/*
 		 * application/controller
 		 * @info Fired when the application controller is ready.
 		 * 
 		 * Read more about hooks in App Docs.
 		 * @link https://github.com/jakerb/appuccino/wiki
 		 */

	    $appuccino.action.add('application/controller', function() {

	        var $scope = this;
	        var $debugging = (typeof MYA_PREVIEW !== 'undefined');

	    });

	}

 })();
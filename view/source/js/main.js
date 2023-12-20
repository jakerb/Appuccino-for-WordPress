
/**
 * Provide some Javascript to be included within your application.
 *
 * @link       https://myappuccino.com/
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
 		 * @link https://dashboard.myappuccino.com/documentation/app/
 		 */

	    $appuccino.action.add('application/controller', function() {

	        var $scope = this;
	        var $debugging = (typeof MYA_PREVIEW !== 'undefined');

	    });

	}

 })();
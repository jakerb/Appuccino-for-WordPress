
/**
 * @name       Hello World
 * @info       I am a demostration plugin for you to look at. 
 * @link       https://github.com/jakerb/Appuccino-for-WordPress
 * @usage 	   this.helloWorldPlugin.greet('Simon'); //Output: Hello Simon!
 * @since      1.0.0
 *
 * @package    Appuccino
 */

 (function() {

 	if(typeof $appuccino !== 'undefined') {

 		/* Set the priority to 20 or higher to ensure it's loaded before the controller. */

	    $appuccino.action.add('application/controller', function() {

	    	this.helloWorldPlugin = {

	    		greeting_text: 'Hello',

	    		greet: function($name) {
	    			$name = (typeof $name == 'string' ? $name : 'Anonymous');
	    			return this.greeting_text + ' ' + $name + '!';
	    		}

	    	};

	    }, 20);

	}

 })();
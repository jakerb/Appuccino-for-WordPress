
	/**
     * @name 	JWT Auth Plugin
     * @author 	Jake Bown
     * @version 1.0.0
     * @note 	This plugin requires "JWT Authentication for WP REST API" Wordpress Plugin to work.
     			You can find out more at https://wordpress.org/plugins/jwt-authentication-for-wp-rest-api/
     */

    if(typeof $appuccino !== 'undefined') {

		$appuccino.action.add('application/controller', function() {

		    this.jwtAuthPlugin = {
		        
		        NAME: 'JWT Auth Plugin',
		        AUTHOR: 'Appuccino',
		        VERSION: '1.0.0',
		        SUPPORT_URL: 'https://github.com/jakerb/Appuccino-for-WordPress',

		        PROFILE: false,
		        RESPONSE: false,
		        AUTHENTICATED: false,
		        READY: false,

		        SESSION_KEY: 'account_session_profile',
		        PLUGIN_URLS: {
		        	base: false,
		        	profile: '/wp/v2/users/me',
		        	token: '/jwt-auth/v1/token',
		        	validate: '/jwt-auth/v1/token/validate',
		        },

		        has_auth: function() {
		        	return this.AUTHENTICATED;
		        },

		        construct: function($base_url) {
		        	var $this = this;
		        	$base_url = $base_url || false;

		        	if(!$base_url) {
		        		console.error('%s requires {base_url} to be set on construct, will not construct.', $this.NAME);
		        		return false;
		        	} 

		        	if($base_url && $base_url.substring(0,5).toLowerCase() !== 'https') {
		        		console.error('%s requires that your base URL has an SSL certificate, will not construct.', $this.NAME);
		        		return false;
		        	}

		        	$this.PLUGIN_URLS.base = $base_url;
		        	$this.READY = true;

		        	$appuccino.action.do('application/plugin/jwtauthplugin/construct', $this);

		        	return $this;
		        },

		        logged_in: function($callback) {
		        	var $this = this;
		        	$callback = $this.__callback($callback);

		        	var session_token = $this.get_session('token');

		        	if(!$this.READY) {
		        		return $this.__not_ready();
		        	}

		        	if(!session_token) {
		        		return $callback.apply(false);
		        	}

		        	if($appuccino.config.network.STATUS !== 'online') {
		        		return $callback.apply(true);
		        	}

		        	$this.__ajax_header(session_token);

		        	jQuery.post($this.PLUGIN_URLS.base + $this.PLUGIN_URLS.validate)
		        	.done(function(response) {
		        		var success = typeof response.data == 'object' && response.data.status == 200;
		        		$this.AUTHENTICATED = true;
		        		return $callback.apply(success);
		        	})
		        	.fail(function() {
		        		$this.AUTHENTICATED = false;
		        		return $callback.apply(false);
		        	});


		        },


		        logout: function($redirect) {
		        	var $this = this;
		        	$redirect = $redirect || false;

		        	if(!$this.READY) {
		        		return $this.__not_ready();
		        	}

		        	localStorage.removeItem($this.SESSION_KEY);
		        	$this.RESPONSE = $this.PROFILE = $this.AUTHENTICATED = false;

		        	if($redirect) {
		        		window.location.hash = $redirect;
		        	}

		        	return $this;
		        },

		        authenticate: function($username, $password, $callback) {
		        	var $this = this;
		        	$callback = $this.__callback($callback);
		        	$username = $username || false;
		        	$password = $password || false;

		        	if(!$username || !$password) {
		        		return $callback.apply(false);
		        	}

		        	if(!$this.READY) {
		        		return $this.__not_ready();
		        	}

		        	jQuery.post($this.PLUGIN_URLS.base + $this.PLUGIN_URLS.token, {
		        		username: $username,
		        		password: $password
		        	})
		        	.done(function(response) {
		        		if(typeof response.token == 'undefined') {
		        			$this.AUTHENTICATED = false;
		        			return $callback.apply(false);
		        		}

		        		$this.PROFILE = response;
		        		$this.AUTHENTICATED = true;
		        		localStorage.setItem($this.SESSION_KEY, JSON.stringify($this.PROFILE));

		        		return $callback.apply($this.PROFILE);

		        	})
		        	.fail(function(error) {
		        		$this.RESPONSE = error;
		        		$this.PROFILE = false;
		        		$this.AUTHENTICATED = false;
		        		return $callback.apply(false);
		        	});
		        },


		        get_session: function($key) {
		        	var $this = this;
		        	var session = localStorage.getItem($this.SESSION_KEY);
		        	$key = $key || false;

		        	if(!$this.READY) {
		        		return $this.__not_ready();
		        	}

		        	if(session) {
		        		session = JSON.parse(session);
		        	}

		        	return session ? ($key ? (typeof session[$key] !== 'undefined' ? session[$key] : false) : session) : false;
		        },

		        __callback: function($callback) {
		        	return (typeof $callback == 'function' ? $callback : function() {});
		        },

		        __error: function() {
		        	var $this = this;
		        	return $this.RESPONSE;
		        },

		        __not_ready: function() {
		        	var $this = this;
		        	console.error('%s is not set as ready, ensure it has been constructed and there are no errors.', $this.NAME);
		        },

		        __ajax_header: function($token) {
		        	jQuery.ajaxSetup({
					    beforeSend: function(xhr) {
					        xhr.setRequestHeader('Authorization', 'Bearer ' + $token);
					    }
					});
		        },
		        

		    };

		}, 20);
	}

/**
 * @name       Off Canvas Polyfill
 * @info       Added fix to auto toggle the off-canvas sidebar.
 * @link       https://myappuccino.com/question/automatically-close-the-sidebar-off-canvas-when-the-view-changes/
 * @since      1.1.1
 *
 * @package    Appuccino
 */

 (function() {

 	if(typeof $appuccino !== 'undefined') {

 		$appuccino.action.add('application/controller', function() {

		    var $scope = this;
		    var $debugging = (typeof MYA_PREVIEW !== 'undefined');

		    if($debugging) {
		        $scope.$on('$routeChangeStart', function() {
		            $appuccino.action.do('application/router/rootscope/transition/before', this);
		        });
		    }

		    /*
		     * @fix     Offcanvas hide
		     * @since   1.1.1 (appy ippo)
		     * @note    Remove offcanvas before the page transition begins.
		     *          This is a fix to stop the "sidebar" from showing when the view changes.
		     */

		    $appuccino.action.add('application/router/rootscope/transition/before', function() {
		        var $offcanvas_target = 'div[uk-offcanvas]';
		        jQuery($offcanvas_target).remove();
		    });
	});

	}

 })();
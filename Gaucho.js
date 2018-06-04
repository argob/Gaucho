var Gaucho = {

	init: function () {
    $( '#user-button' ).on( 'click', function () {
      var userMenu = $( '<ul>' ).id( 'user-menu' );
      var popup = new OO.ui.PopupWidget( {
        $content: userMenu,
        padded: true,
        align: 'force-left',
        autoClose: true
      });
      $( this ).append( popup.$element );
      popup.toggle();
	  });
  }
}

$( Gaucho.init );
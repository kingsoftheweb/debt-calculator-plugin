let DCP = {

	elements  : {
		kotwCopyright : document.querySelector( 'div#kotw-footer' )
	},
	events    : () => {
		/** On Page Load Events **/

		// Check if footer astra theme exists.
		if( document.querySelectorAll( 'footer .ast-container' ).length > 0 ) {
			console.log( 'footer astra exists' );
			let astraFooter = document.querySelector( 'footer .ast-container' )
			let kotwCopyright  = DCP.elements.kotwCopyright;
			console.log( astraFooter, kotwCopyright );

			astraFooter.insertAdjacentHTML( 'beforeend', "<div id = 'kotw-footer'>" + kotwCopyright.innerHTML + "</div>" );
			kotwCopyright.remove();
		}
	},
	functions : {
	},
	init : () => {
		DCP.events();
	}
};

window.addEventListener('DOMContentLoaded', (event) => {
	DCP.init();

});

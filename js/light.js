/**
 * toggle_light() - Switch between dark & light mode
 *
 * This function checks the <body> class, and inverts it
 * (if class="dark", invert to "light", otherwise "dark"),
 * then the cookie containing the theme preference is updated.
*/
function toggle_light() {
	var l = document.body.className;
	document.body.className = "dark" == l ? "light" : "dark";
	l = document.body.className;
	update_cookie();
}

/**
 * update_cookie() - Update the theme preference cookie
 *
 * This function updates the "theme" cookie, and sets its value
 * to either "dark" (for dark mode), or "light" (for light mode)
*/
function update_cookie() {
	// Delete pre-existing cookie
	document.cookie="theme=;path='/';SameSite=Lax;expires="+(new Date(0)).toUTCString();

	// Set new cookie
	document.cookie="theme="+document.body.className+";path=/;SameSite=Lax";
}

/**
 * getCookie() - Get a cookie
 * @cname: The cookie whose value is to be returned
 *
 * This function gets a parameter "cname" (cookie name)
 * and tries to fetch the cookie with the same name;
 * if it is found, its value is returned.
*/
function getCookie(cname) {
	let name = cname + "=";
	let decodedCookie = decodeURIComponent(document.cookie);
	let ca = decodedCookie.split(';');
	for (let i = 0; i <ca.length; i++) {
		let c = ca[i];

		while (c.charAt(0) == ' ')
			c = c.substring(1);

		if (c.indexOf(name) == 0)
			return c.substring(name.length, c.length);
	}
	return "";
}

/**
 * remember_prefs() - Remember theme preferences
 *
 * This function checks theme preferences --
 * first, the function checks if the browser wants/prefers dark mode;
 * if it does, we set the <body> class to dark mode,
 * and we update the cookie containing theme preferences,
 * otherwise we set it to light, while still updating the cookie.
*/
function remember_prefs() {
	// Get browser light setting
	let dm_user = window.matchMedia("(prefers-color-scheme:dark)").matches;

	// Check cookie state, if set
	if (document.cookie != "")
		document.body.className = getCookie("theme");
	else {
		// Change accordingly
		document.body.className = dm_user == true ? "dark" : "light";
                update_cookie();
        }
}

// RPECK 24/08/2023 - Announcement Bar JS code
// Extracted from Kadence Elements in order to provide standardised functionality
class AnnouncementBar extends HTMLElement {

    // RPECK 24/08/2023 - Construct the element
    // Gives us the means to manage how it should behave
    constructor() {

        // If you define a constructor, always call super() first!
        // This is specific to CE and required by the spec.
        super();

    }

    // RPECK 24/08/2023 - ConnectedCallback
    // Triggers only when the element is connect (IE allows us to build the system in a more robust way)
    connectedCallback() {

        // RPECK 22/08/2023 - Update height
        // If the 'hide' cookie is set, then keep the thing closed, otherwise open
        this.open(!this.readCookie('hide'));
        
        // RPECK 21/08/2023 - Add click event
        // This gives us the means to trigger code when the button is clicked
        this.addEventListener("click", function(event) {

            // RPECK 24/08/2023 - Check for class of target
            // This allows us to only trigger for the close button 
            if(!event.target.classList.contains('close-popup')) return false;
            
            // RPECK 24/08/2023 - Add cookie on button click
            // Removes the announcement bar
            this.createCookie('hide', true, 1);
            
            // RPECK 21/08/2023 - Height
            // Used to hide the announcement bar
            this.open(false);
        
        });

    }

    // RPECK 24/08/2023 - Open/Close
    // Function which populates the 'data-open' attribute
    open (toggle) {
        this.setAttribute('data-open', toggle);
    }

    // RPECK 24/08/2023 - Create cookie
    // This is used to give us the ability to define if the user should see the element or not
    createCookie (name,value,days) {
        if (days) {
            var date = new Date();
            date.setTime(date.getTime()+(days*24*60*60*1000));
            var expires = "; expires="+date.toGMTString();
        } else {
            var expires = "";
        }
        document.cookie = name+"="+value+expires+"; path=/";
    }

    readCookie (name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
        }
        return false;
    }

    eraseCookie (name) {
        this.createCookie(name,"",-1);
    }

}

// RPECK 24/08/2023 - Connect the Element
// This gives us the ability to interface with the element directly (instead of waiting for the DOM to load)
customElements.define('announcement-bar', AnnouncementBar);
(function () {

    let cookieManager = Cookies.noConflict();

    /**
     * Sets a cookie given a value.
     *
     * @param {string} name the name of the cookie
     * @param {string} value the value of the cookie
     * @param {boolean} override whether to override the cookie if it already exists (default: false)
     */
    let setCookie = function setCookie(name, value, override) {

        if (!override && typeof(cookieManager.get(name)) != 'undefined') {
            return;
        }

        cookieManager.set(name, value, {
            domain : '.' + window.location.host
        });

    }

    // Store any UTM parameters if they are in the query
    // Note - this code does not take into account array query variables, as they are not expected
    let strUrl = window.location.href;
    let query = {};

    var posQuery = strUrl.indexOf("?");

    if (posQuery >= 0) {
        let strQuery = strUrl.substr(posQuery + 1);

        strQuery.split("&").forEach(function parsePart(part) {

            if (!part) {
                return;
            }

            part = part.split("+").join(" ")

            let posEq = part.indexOf("=");

            let key = posEq > -1 ? part.substr(0, posEq) : part;

            key = key.toLowerCase();

            if (key.substr(0, 4) != 'utm_') {
                return;
            }

            let value = posEq > -1 ? decodeURIComponent(part.substr(posEq + 1)) : "";

            setCookie(key, value, true);

        });
    }

    // Store the landing page as a session cookie, if not already set
    setCookie('ref_landing', window.location.protocol + "//" + window.location.host + window.location.pathname);

    // Store the referrer as a session cookie, if not already set
    setCookie('ref_referer', document.referrer);

})();

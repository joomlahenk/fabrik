/**
 * Block Until Fabrik is Ready
 * 
 * This code blocks all user input until the Fabrik susbsystem is ready.
 *
 * @copyright: Copyright (C) 2005-2016  Media A-Team, Inc. - All rights reserved.
 * @license:   GNU/GPL http://www.gnu.org/copyleft/gpl.html
 */

var onFabrikReadyBody = false;
var blockDiv = '<div id="blockDiv" style="position:absolute; left:0; right:0; height:100%; width:100%; z-index:999;"></div>';

function onFabrikReady() {
    if (typeof Fabrik === "undefined") {
        if (onFabrikReadyBody === false && typeof document.getElementsByTagName("BODY")[0] !== "undefined") {
            onFabrikReadyBody = document.getElementsByTagName("BODY")[0];
            onFabrikReadyBody.insertAdjacentHTML('afterbegin', blockDiv);
            $("#blockDiv").click(function(e) {
                alert("Fabrik is still loading, please wait a few second");
                return false;
            });
        }    
        setTimeout(onFabrikReady, 50);
    } else {
        $("#blockDiv").remove();
    }
}


if (document.readyState !== 'loading') {
    onFabrikReady();
} else {
    document.addEventListener('DOMContentLoaded', onFabrikReady()); 
}


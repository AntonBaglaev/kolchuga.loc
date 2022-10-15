$(function(){

    var objMenu = $(".aim_catalog>ul, .aim_catalog>ul>li>ul");

    objMenu.menuAim({
        activate: activateSubmenu,
        deactivate: deactivateSubmenu
    });

    function activateSubmenu(row) {
        var objRow = $(row),
            submenuId = objRow.data("submenuId"),
            objSubmenu = $("#" + submenuId),
            height = objMenu.outerHeight(),
            width = objMenu.outerWidth();

        // Show the submenu
        objSubmenu.css({
            display: "block"
        });

        // Keep the currently activated row's highlighted look
        objRow.find("a").addClass("maintainHover");
    }

    function deactivateSubmenu(row) {
        var objRow = $(row),
            submenuId = objRow.data("submenuId"),
            objSubmenu = $("#" + submenuId);
            //console.log(submenuId);

        // Hide the submenu and remove the row's highlighted look
        objSubmenu.css("display", "none");
        objRow.find("a").removeClass("maintainHover");
    }

});
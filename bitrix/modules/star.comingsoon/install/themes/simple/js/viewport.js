var meta_viewport = document.getElementById('viewport');

if ( screen.width < 1100 ) {
  if ( screen.width < 750 ) {
    if ( screen.width > screen.height ) {
      meta_viewport.setAttribute('content','width=760,user-scalable=0');
    } else {
      meta_viewport.setAttribute('content','width=360,user-scalable=0');
    }
  } else {
    if ( screen.width > screen.height ) {
      meta_viewport.setAttribute('content','width=1030,user-scalable=0');
    } else {
      meta_viewport.setAttribute('content','width=760,user-scalable=0');
    }
  };
} else {
  meta_viewport.setAttribute('content','width=device-width,user-scalable=0');
};

window.addEventListener("resize", function() {
  if ( screen.width < 1100 ) {
    if ( screen.width < 750 ) {
      if ( screen.width > screen.height ) {
        meta_viewport.setAttribute('content','width=760,user-scalable=0');
      } else {
        meta_viewport.setAttribute('content','width=360,user-scalable=0');
      }
    } else {
      if ( screen.width > screen.height ) {
        meta_viewport.setAttribute('content','width=1030,user-scalable=0');
      } else {
        meta_viewport.setAttribute('content','width=760,user-scalable=0');
      }
    };
  } else {
    meta_viewport.setAttribute('content','width=device-width,user-scalable=0');
  };
});
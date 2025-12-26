(function ($) {
  "use strict";

  $(document).ready(function () {
    const lenis = new Lenis();
    function raf(time) {
      lenis.raf(time);
      requestAnimationFrame(raf);
    }
    requestAnimationFrame(raf);
  });
  
})(jQuery);

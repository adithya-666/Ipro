$(window).on("ready", function(e) {
    $.ajax({
      type: 'POST',
      async: false,
      url: '/logout'
    });
});
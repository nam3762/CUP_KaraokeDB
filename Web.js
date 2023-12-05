$(document).ready(function () {
  $(".year_label").click(function (e) {
    $(this).children().toggle();
    $(this).siblings().children().hide();
  });

  $(".search").click(function (e) {
    $("#karaoke_list").hide();
    $("#searchbox").show();
  });

  $(".searchoff").click(function (e) {
    $("#searchbox").hide();
    $("#karaoke_list").show();
  });
});


$(document).on("click", ".w-tabs-tab-item", function () {
    var obj = $(this);
    var id = obj.attr("id");
    $(".w-tabs-panel-item").hide();
    $(".w-tabs-panel-item." + id).fadeIn();
    $(".w-tabs-tab-item").removeClass("w-tabs-tab-item-selected");
    obj.addClass("w-tabs-tab-item-selected");
});
/*!
 * Application Ajax
 * Created by : Septi Setiawati
 * Email : septi.setiawati@gmail.com
 */
jQuery(document).ready(function () {
    $('.group-checkable').change(function () {
        var set = $(this).attr("data-set");
        var checked = $(this).is(":checked");
        $(set).each(function () {
            if (checked) {
                $(this).prop("checked", true);
            } else {
                $(this).prop("checked", false);
            }
            $(this).parents('tr').toggleClass("active");
        });
        $.uniform.update(set);
    });
});
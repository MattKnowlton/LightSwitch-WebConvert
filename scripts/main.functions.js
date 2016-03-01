

$.fn.serializeObject = function()
{
    var o = {};
    var a = this.serializeArray();
    $.each(a, function() {
        o[this.name] = this.value || '';
    });
    return o;
};

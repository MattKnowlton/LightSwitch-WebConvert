$(document).ready(function(){
    var ajaxCon = new ajax;
    window.ajaxCon = ajaxCon;
});

function ajax() {

    this.callback = {};
    this.i = 0;

    //user defineable function
    this.ajaxFailure = function (returnData) {
        //alert('ajaxCon Module '+returnData.function+' not accessible');
    };

    //user defineable function
    this.ajaxSuccess = function (returnData) {};

    this.call = function(functionName, argumentArray, callback, async, modulePath){
        this.i++;
        this.callback[this.i] = callback;

        settings = $.extend(true, {}, this.ajaxSettings, {data:{'ajaxFunction':functionName, 'arguments':argumentArray, ajaxI:this.i}} );

        if(typeof(async) != "undefined" && !async) settings = $.extend(true, {}, settings, { async:false });
        if(!!modulePath) settings = $.extend(true, {}, settings, { url:modulePath });

        $.ajax(settings);
    };

    this.ajaxReturn = function (returnData){

        if(typeof returnData != "object"){
            returnData = returnData.substring(returnData.indexOf("{") - 1);
            returnData = returnData.substring(0, returnData.lastIndexOf("}") + 1);
            var responseArray = $.parseJSON(returnData);
        } else {
            responseArray = returnData;
        }


        if (responseArray == false || responseArray.Message.toLowerCase() != "success"){
            this.ajaxFailure(responseArray);
            return;
        }

        this.ajaxSuccess(responseArray);

        responseArray.Return = responseArray.return = responseArray.r = responseArray.Return;
        responseArray.Array = responseArray.array = responseArray.out = responseArray.Return;

        if(this.callback[responseArray.ajaxI] != false) {
            this.callback[responseArray.ajaxI](responseArray);

            setTimeout(function(){
                ajaxCon.callback[responseArray.ajaxI] = false;
            },100);
        }
    };

    window.ajaxCon = this;
    if(typeof(window._token) == "undefined") window._token = null;
    this.ajaxSettings = { url: window.location.href, type: 'POST', cache: false, data: {ajaxRequest: true, _token: window._token}, success: function (returnData) {
        ajaxCon.ajaxReturn(returnData)
    }};
}
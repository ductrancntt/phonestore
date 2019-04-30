let AlertService = (function (bootoast) {
    /*custom at: https://github.com/odahcam/bootoast*/
    function success(mes, time, pos) {
        bootoast.toast({
            message: mes,
            type: 'success',
            position: pos ? pos : 'top-right',
            timeout: time ? time: 2,
        });
    }
    function error(mes, time, pos) {
        bootoast.toast({
            message: mes,
            type: 'danger',
            position: pos ? pos : 'top-right',
            timeout: time ? time: 2,
        });
    }
    return {
        success: success,
        error: error
    }
})(bootoast);
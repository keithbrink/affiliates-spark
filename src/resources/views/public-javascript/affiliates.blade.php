var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;
  
    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');
  
        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
    return false;
};

if(getUrlParameter('ref')) {
    affiliate_token = getUrlParameter('ref');
    $('<img />', {
        src: '{{url('/a-s/s')}}/'+affiliate_token,
        style: 'display: none;',
    }).appendTo($('#mainNav'));
}
function number_format(number, decimals = 2, dec_point = '.', thousands_sep = ' ') {

    let sign = number < 0 ? '-' : '';

    let s_number = Math.abs(parseInt(number = (+number || 0).toFixed(decimals))) + "";
    let len = s_number.length;
    let t_chunk = len > 3 ? len % 3 : 0;

    let ch_first = (t_chunk ? s_number.substr(0, t_chunk) + thousands_sep : '');
    let ch_rest = s_number.substr(t_chunk)
        .replace(/(\d\d\d)(?=\d)/g, '$1' + thousands_sep);
    let ch_last = decimals ?
        dec_point + (Math.abs(number) - s_number)
            .toFixed(decimals)
            .slice(2) :
        '';

    return sign + ch_first + ch_rest + ch_last;
}

function phone_format(value, pattern = '# ### ### ####') {
    let i = 0, v = value.toString();
    return pattern.replace(/#/g, _ => v[i++]);
}
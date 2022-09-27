const Platform = {
    LEX:"LEX",
    ANTARAJA:"ANTARAJA",
    JNE:"JNE",
    COOR:"COOR",
    NINJA:"NINJA",
    SHOPEE:"SHOPEE",
    SAMEDAY:"SAMEDAY",
    JX:"JX",
    INSTANT:"INSTANT",
    SH_INSTANT:"SH_INSTANT",
}

function validLEX(str) {
    if (str.length < 15) {
        return false;
    }else if ((!(str.includes("LXAD")))|| (!(str.includes("JNAP")))||(!(str.includes("NLIDAP")))) {
        return true;
    }else{
        return false;
    }
}
function validSHOPEE(str) {
    if (str.length < 17) {
        return false;
    }else if (str.includes("SPXID")) {
        return true;
    }else{
        return false;
    }
}
function validSH_INSTANT(str) {
    if (str.length < 19) {
        return false;
    }else{
        return false;
    }
}

function validReceipt(str) {
    let query = getQueryString();
    let bool = true;
    switch (query) {
        case Platform.LEX:
            bool = validLEX(str)
            break;
        case Platform.SHOPEE:
            bool = validSHOPEE(str)
            break;
        case Platform.SH_INSTANT:
            bool = validSH_INSTANT(str)
            break;
        case Platform.ANTARAJA:
            bool = true;
            break;
        case Platform.COOR:
            bool = true;
            break;
        case Platform.INSTANT:
            bool = true;
            break;
        case Platform.JNE:
            bool = true;
            break;
        case Platform.JX:
            bool = true;
            break;
        case Platform.NINJA:
            bool = true;
            break;
        case Platform.SAMEDAY:
            bool = true;
            break;
        case Platform.SH_INSTANT:
            bool = true;
            break;
    
        default:
            bool = false;
            break;
    }
    return bool;
}
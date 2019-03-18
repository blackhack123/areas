/*
librería de funciones realizadas, compiladas o recodificadas
por nerdcoder.com
uso gratuito, sin copyright, ni nada, se entrega AS IS.
www.nerdcoder.com
*/
var nerdcoder = {
    //rellena una cadena hasta el largo indicado con el caracter especificado
    lpad: function(cadena, largo, caracter) {
        for (i = cadena.length + 1; i <= largo; i++) {
            cadena = caracter + cadena;
        }
        return cadena;
    },
    //calcula y devuelve el digito verificador de un rut
    digitoVerificador: function(T) {
        var M = 0,
        S = 1;
        for (; T; T = Math.floor(T / 10)) {
            S = (S + T % 10 * (9 - M++%6)) % 11;
        }
        return S ? S - 1: 'K';
    },
    //compara el rut entregado con el rut sin digito + el digito calculado
    rutValido: function(rut) {
        rut = this.lpad(rut, 9, '0');
        var rut_sdv = rut.substring(0, 8);
        var dv = this.digitoVerificador(rut_sdv);
        rut_sdv = rut_sdv + dv;
        if (rut.toLowerCase() === rut_sdv.toLowerCase()) {
            return true;
        } else {
            return false;
        }
    },
    //union de ambas funciones ltrim y rtrim
    trim: function(str, chars) {
        return ltrim(rtrim(str, chars), chars);
    },
    //ltrim quita los espacios o caracteres indicados al inicio de la cadena
    ltrim: function(str, chars) {
        chars = chars || "\\s";
        return str.replace(new RegExp("^[" + chars + "]+", "g"), "");
    },
    //rtrim quita los espacios o caracteres indicados al final de la cadena
    rtrim: function(str, chars) {
        chars = chars || "\\s";
        return str.replace(new RegExp("[" + chars + "]+$", "g"), "");
    }
};
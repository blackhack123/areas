var nerdcoder={lpad:function(cadena,largo,caracter){for(i=cadena.length+1;i<=largo;i++){cadena=caracter+cadena}return cadena},digitoVerificador:function(T){var M=0,S=1;for(;T;T=Math.floor(T/10)){S=(S+T%10*(9-M++%6))%11}return S?S-1:'K'},rutValido:function(rut){rut=this.lpad(rut,9,'0');var rut_sdv=rut.substring(0,8);var dv=this.digitoVerificador(rut_sdv);rut_sdv=rut_sdv+dv;if(rut.toLowerCase()===rut_sdv.toLowerCase()){return true}else{return false}},trim:function(str,chars){return ltrim(rtrim(str,chars),chars)},ltrim:function(str,chars){chars=chars||"\\s";return str.replace(new RegExp("^["+chars+"]+","g"),"")},rtrim:function(str,chars){chars=chars||"\\s";return str.replace(new RegExp("["+chars+"]+$","g"),"")}};
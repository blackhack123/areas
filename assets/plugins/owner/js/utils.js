jQuery.datetimepicker.setLocale('es');

// US common date timestamp
Date.prototype.fechaHoraActual = function() {
  var yyyy = this.getFullYear().toString();
  var mm = (this.getMonth()+1).toString(); // getMonth() is zero-based
  var dd  = this.getDate().toString();
  var h = this.getHours().toString();
  var m = this.getMinutes().toString();
  var s = this.getSeconds().toString();

  return (mm[1]?mm:"0"+mm[0]) + "-" + (dd[1]?dd:"0"+dd[0]) + "-" + yyyy + " - " + ((h > 12) ? h-12 : h) + ":" + m + ":" + s;
};



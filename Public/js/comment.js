String.prototype.print_f = function() {
    var formatted = this;
    for (var i = 0; i < arguments.length; i++) {
        var regexp = new RegExp('\\{'+i+'\\}', 'gi');
        formatted = formatted.replace(regexp, arguments[i]);
    }
    return formatted;
};
String.prototype.format= function(){
 var args = arguments;
 return this.replace(/\{(\d+)\}/g,function(s,i){
   return args[i];
 });
}

function confirmdel(str){   
    return confirm(str);   
} 
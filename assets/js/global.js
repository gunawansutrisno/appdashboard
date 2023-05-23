$(function(){
    $('.money-input').mask("#.##0", {reverse: true}); 
});

function toCurrency(n) {   
  n = parseFloat(n);
    return n.toFixed(0).replace(/./g, function(c, i, a) {
        return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "." + c : c;
    });
}

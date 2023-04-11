
function copy_paste_number_atrib(atrib_origi, atrib_dest, maximo_ent, max_dec){
  var returnString = "";
  let valor = document.getElementById(atrib_origi).value;
  var anArray = valor.split('');
  var cant = anArray.length;
  var cant_number = 0;
  for(var i=0; i<cant; i++) {
    if(((anArray[i] > 0 && anArray[i] <= 9 && anArray[i] != " ") || (anArray[i] == ",")) && cant_number < maximo_ent){
      if(anArray[i] == ","){
        returnString += ".";
      }else{
        cant_number++;
        returnString += anArray[i];
      }
    }else{
      if(((anArray[i] == 0 && i > 0 && anArray[i] != " ") || (anArray[i] == ",")) && cant_number < maximo_ent){
        if(anArray[i] == ","){
          returnString += ".";
        }else{
          cant_number++;
          returnString += anArray[i];
        }
      }
    }
  }
  document.getElementById(atrib_dest).value = returnString!=""?parseFloat(returnString):"";
}

$("input[data-type='currency']").on({
    keyup: function() {
      formatCurrency(1,$(this));
    },
    blur: function() { 
      formatCurrency(1,$(this), "blur");
    }
});

function formatNumber(n) {
  // format number 1000000 to 1,234,567
  return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".")
}

function formatCurrency(position,input, blur) {
  // appends $ to value, validates decimal side
  // and puts cursor back in right position.
  
  // get input value
  //;

  var input_val = position == 2?$("#"+input.id).val():input.val();
  
  // don't validate empty input
  if (input_val === "") { return; }
  
  // original length
  var original_len = input_val.length;

  // initial caret position 
  var caret_pos = position == 2?$("#"+input.id).prop("selectionStart"):input.prop("selectionStart");
  //console.log(caret_pos);
    
  // check for decimal
  if (input_val.indexOf(",") >= 0) {

    // get position of first decimal
    // this prevents multiple decimals from
    // being entered
    var decimal_pos = input_val.indexOf(",");

    // split number by decimal point
    var left_side = input_val.substring(0, decimal_pos);
    var right_side = input_val.substring(decimal_pos);
    left_side = left_side.length<=21?left_side:left_side.substring(0,21);

    //console.log("left_side:"+left_side);
    //console.log("right_side:"+right_side);

    // add commas to left side of number
    left_side = formatNumber(left_side);

    // validate right side
    right_side = formatNumber(right_side);
    
    // On blur make sure 2 numbers after decimal
    if (blur === "blur") {
      right_side += "00";
    }
    
    // Limit decimal to only 2 digits
    right_side = right_side.substring(0, 2);

    // join number by .
    input_val = "$ " + left_side;// + "," + right_side;

  } else {
    // no decimal entered
    // add commas to number
    // remove all non-digits

    input_val = input_val.length<=21?input_val:input_val.substring(0,21);
    //console.log("input_val:"+input_val);

    input_val = formatNumber(input_val);
    input_val = "$ " + input_val;
    
    // final formatting

    /*if (blur === "blur") {
      input_val += ",00";
    }*/
  }
  
  // send updated string to input
  //if(input_val !== "$ ,00" && input_val !== "$ 0,00"){
  if(input_val !== "$ " && input_val !== "$ 0"){
    position == 2?$("#"+input.id).val(input_val):input.val(input_val);
  }else{
    position == 2?$("#"+input.id).val(""):input.val("");
  }

  //validamos el número sin miles
  id_origen = position == 2?input.id:input[0].id;
  id_dest = position == 2?input.id.substring(0,input.id.length - 4):input[0].id.substring(0,input[0].id.length - 4);


  //console.log("id_origen: "+id_origen);
  //console.log("id_dest: "+id_dest);
  copy_paste_number_atrib(id_origen, id_dest, 15,2);

  if(position == 2){
    pres_check();
  }
  // put caret back in the right position
  var updated_len = input_val.length;
  caret_pos = updated_len - original_len + caret_pos;
  position == 2?input.setSelectionRange(caret_pos, caret_pos):input[0].setSelectionRange(caret_pos, caret_pos);
}
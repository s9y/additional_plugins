function showConfig(id) {
    if (document.getElementById) {
        dlm = document.getElementById(id);
        if (dlm.style.display == 'none') {
            document.getElementById('option' + id).src = dlm_minus;
            dlm.style.display = '';
        } else {
            document.getElementById('option' + id).src = dlm_plus;
            dlm.style.display = 'none';
        }
    }
}

var state='';
function showConfigAll(count) {
    if (document.getElementById) {
        for (i = 1; i <= count; i++) {
            document.getElementById('dlm' + i).style.display = state;
            document.getElementById('optiondlm' + i).src = (state == '' ? dlm_minus : dlm_plus);
        }

        if (state == '') {
            document.getElementById('optionall').src = dlm_minus;
            state = 'none';
        } else {
            document.getElementById('optionall').src = dlm_plus;
            state = '';
        }
    }
}

function chkAll(frm, arr, mark) {
  for (i = 0; i <= frm.elements.length; i++) {
   try {
     if(frm.elements[i].name == arr) {
       frm.elements[i].checked = mark;
     }
   } catch (err) {}
  }
}


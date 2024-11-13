    var the_button_id = 0;
    function toggleForm(formid, buttonid){
        the_button_id = buttonid;
        theform = document.getElementById(formid);
        thebutton = document.getElementById('button-'+buttonid);
        old_state = theform.style.display;
        new_form_state = (old_state == 'inline') ? 'none' : 'inline';
        new_button_state = (old_state == 'inline') ? 'inline' : 'none';
        theform.style.display = new_form_state;
        thebutton.style.display = new_button_state;

        if(new_form_state == 'inline'){
            if(theform.reports_to) theform.reports_to.value = buttonid;
            if(theform.position_id) theform.position_id.value = buttonid;
            document.getElementById('hierarchies').style.opacity='0.1';
            document.getElementById('button-0').style.display = 'none';
        }
        else{
            document.getElementById('hierarchies').style.opacity='1';
            document.getElementById('button-0').style.display = 'inline';
        }
    }


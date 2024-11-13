<link rel="stylesheet" href="/vendor/hierarchies/assets/hierarchies.css" />
<link href="{{ config('hierarchies.fontawesome_path') }}/css/fontawesome.css" rel="stylesheet" />
<link href="{{ config('hierarchies.fontawesome_path') }}/css/solid.css" rel="stylesheet" />
<link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
<script src="/vendor/hierarchies/assets/hierarchies.js"></script>
<script>
$( function() {
$('#user-look-up').autocomplete({
    source:function(request, response){
          $.ajax( {
          url: "{{ config('hierarchies.base_path') }}/suggest_user",
          data: {
            term: request.term
          },
          success: function( data ) {
            response( $.map( data.suggestions, function( item ) {
                        return {
                            label: item.name + ' | (' + item.email +')',
                            value: item.email
                        }
                    }));
          }
        } );
    },
    minLength:2,
});
});
</script>
 
<a href="javascript:toggleForm('addition-form','0')" id="button-0"><i class="fa-solid fa-add"></i></a>
<form method="post" action="{{ route('add_position') }}" class="hidden" id="addition-form">
    @csrf
    <input type="text" name="label" value="" placeholder="New position" />
    <input type="hidden" name="reports_to" value="" />
    <button type="submit" value="Add"><i class="fa-solid fa-add"></i></button>
    <button type="button" value="Cancel" onclick="toggleForm('addition-form', the_button_id)"><i class="fa-solid fa-cancel"></i></button>
</form>
<form method="post" action="{{ route('fill_position') }}" class="hidden" id="fill-position-form">
    @csrf
    <input type="text" id="user-look-up" name="user" value="" placeholder="User look up" />
    <input type="hidden" name="position_id" value="" />
    <button type="submit" value="Add"><i class="fa-solid fa-add"></i></button>
    <button type="button" value="Cancel" onclick="toggleForm('fill-position-form', the_button_id)"><i class="fa-solid fa-cancel"></i></button>
</form>
<div id="hierarchies">
    @php
        $positions = \CarvingIT\Hierarchies\Models\Position::all();
        function makeTree($positions, $parent_id = null){
            foreach($positions as $p){
                if($p->reports_to == $parent_id){
                    // users on that position
                    $position_users = '';
                    foreach($p->positionusers as $pu){
                        $position_users .= ' ('.$pu->user->name.')
                        <form method="post" onsubmit="return confirm(\'Are you sure you want to delete this position?\');" action="'.route('remove_position_user').'" style="display:inline-block;">
                        <input type="hidden" name="position_user_id" value="'.$pu->id.'" />
                        <input type="hidden" name="_token" value="'. csrf_token(). '" />
                        <button type="submit" title="Remove this user from this position" value="x" style="color:red;"><i class="fa-solid fa-user-minus"></i></button></button>
                        </form>';

                    }
                    echo "<article>";
                    if(count($p->reports) > 0){
                        echo "<details>";
                        echo "<summary>".$p->label.
                            $position_users.
                            ' <button title="Add reporting position" onclick="javascript:toggleForm(\'addition-form\', \''.$p->id.'\')" id="button-'.$p->id.'"><i class="fa-solid fa-turn-down"></i></button><button title="Fill position" onclick="javascript:toggleForm(\'fill-position-form\', \''.$p->id.'\')"><i class="fa-solid fa-user-plus"></i></button></p>'.
                        "</summary>"; 
                        makeTree($positions, $p->id);
                        echo "</details>";
                    }
                    else{
                        echo '<div class="child">'.$p->label.
                        $position_users.
                        ' <button title="Add reporting position" onclick="javascript:toggleForm(\'addition-form\', \''.$p->id.'\')" id="button-'.$p->id.'"><i class="fa-solid fa-turn-down"></i></button><button title="Fill position" onclick="javascript:toggleForm(\'fill-position-form\', \''.$p->id.'\')"><i class="fa-solid fa-user-plus"></i></button>
                        <form method="post" onsubmit="return confirm(\'Are you sure you want to delete this position?\');" action="'.route('remove_position').'" style="display:inline-block;">
                        <input type="hidden" name="position_id" value="'.$p->id.'" />
                        <input type="hidden" name="_token" value="'. csrf_token(). '" />
                        <button type="submit" title="Remove this position" value="x" style="color:red;"><i class="fa-solid fa-trash"></i></button></button>
                        </form>
                        
                        </div>';
                    }
                    echo "</article>";
                }
            } 
        }

        makeTree($positions);
    @endphp
</div>

<div id='note-{$note.id}'>
    <div class='note-header'>
        <div class='note-by'><b>{$note.note_type}</b>: {$full_name}</div>
        <div class='note-date'>{$date}</div>
    </div>
     <div style='clear:both'></div>
    <p class='note'>{$note.note}</p>
    <div class='note-options'>
        <div style="position:relative;top:-4px;">{cfield field=note_type value=''}</div>
        {if $user->can_access('note','delete')}<a title='Delete Note'  class='table-delete-link' href='/note/delete/{$note.id}/{$profile_id}'></a>{/if}&nbsp;&nbsp;
        {if $user->can_access('note','edit')}<a href='/note/edit/{$note.id}/{$profile_id}' title='Edit Note' class='table-edit-link'></a>{/if}
    </div>
     <div style='clear:both'></div>
</div>
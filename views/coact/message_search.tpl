<table class="table-short" style="width:100% !important">
    <thead>
        <tr>
            <td>Date</td>
            <td>Title</td>
            <td>Message</td>
            {if $user->is_admin()}
                {if $box eq 'inbox'}
                    <td>From</td>
                {else}
                {/if}
            {/if}
        </tr>
    </thead>

    <tbody>
        {section name=inst loop=$messages}
            <tr {cycle values="class='odd',"}>
                <td >
                    {if $messages[inst].opened eq 0 and $box neq 'outbox'}
                        <img src="/views/app/images/unread.png" style="position:relative;top:8px;">&nbsp;
                    {/if}
                    <small style="font-size:10px;">{$messages[inst].created_on|date_format}</small>
                </td>
                <td class="col-second"><a href="/message/view/{$messages[inst].id}">{$messages[inst].title|truncate:30}</a></td>
                <td >{$messages[inst].message|strip_tags|truncate:28}</td>
                {if $user->is_admin()}

                    <td class="col-second">
                        {if $box eq 'inbox'}
                            <a href="/{$messages[inst].sender_id}">{$messages[inst].name} {$messages[inst].surname}</a>
                        {else}
                            {$messages[inst].sender}
                        {/if}
                    </td>


                {/if}
            </tr>
        {/section}
    </tbody>
</table>
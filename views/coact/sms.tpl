
{if $ajax}
    {** MORE hackS **}
    <div style="padding:10px">
{/if}


<table class="table-long" style="width:100% !important; ">
    <thead>
        <tr>
            <td>Status</td>
            <td>To</td>
            <td>Sent by</td>
            <td>Message</td>
            <td>Status message</td>

            <td>Sent on</td>
        </tr>
    </thead>

    <tbody>
        {section name=inst loop=$sms}
            <tr>
            	<td><div class="minibutton sms sms-{$sms[inst].status}"><i>&nbsp;*</i>&nbsp;&nbsp;{$sms[inst].status}</td>
            	<td><a href="/{$sms[inst].user_id}">{$sms[inst].name} {$sms[inst].surname}</a></td>
            	<td>{$sms[inst].sender_name} {$sms[inst].sender_surname}</td>
            	<td>{$sms[inst].message}</td>
                <td>{$sms[inst].status_message}</td>
            	<td>{$sms[inst].created_on|date_format}</td>
            </tr>
        {/section}
    </tbody>
</table>


<br />
<br />

{pager url="sms/stats/`$status`/`$page`" current_page=$page total_rows=$sms_count per_page=$per_page}
{if $ajax}
    {** MORE hackS **}
    </div>
{/if}
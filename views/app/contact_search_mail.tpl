<table class="table-short" style="width:100% !important">
<thead>
	<tr>
		<td>Date</td>
		<td>Title</td>
		<td>Recieved from</td>
	</tr>
</thead>

<tbody>
	{section name=inst loop=$mails}
		<tr {cycle values="class='odd',"}>
			<td >
				{$mails[inst].message_date|date_format}</small>
			</td>
			<td class="col-second">
				<a href="/contact/message_view/{$mails[inst].id}">{$mails[inst].subject|truncate:30}</a>
			</td>
			<td >
				{$mails[inst].name}</small>
			</td>
			
		</tr>
	{/section}
</tbody>
</table>
{literal}
<style>
	#black {padding: 5px; }
	#black td {color: #000000; font-size: 10px;}

</style>
{/literal}

<table id="black" width="100%">
	<tr>
		<td>
			<b>Email</b>
		</td>
		<td>
			{$preview->email}
		</td>
	</tr>
	</tr>
		<td>
			<b>Last seen</b>
		</td>
		<td>
			:{$preview->last_seen|date_format}
		</td>
	</tr>
	<tr>
		<td><b>Unread messages</b></td>
		<td>:{$preview->unread_messages()}</td>
	</tr>
	<tr>
		<td><b>Incomplete tasks</b></td>
		<td>:{$preview->incomplete_tasks()}</td>
	</tr>

</table>
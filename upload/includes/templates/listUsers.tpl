{include file = "header.tpl"}

<h2><a href = "admin.php">Admin</a> &raquo; Users</h2>
<h3>List of users</h3>
<table>
	<tr>
		<th>id</th>
		<th>Username</th>
		<th>Registered</th>
		<th>Team</th>
	</tr>
{foreach from = "$userlist" item = "user"}
	<tr>
		<td>{$user.id}</td>
		<td>{$user.username}</td>
		<td>{$user.registered}</td>
		<td>{$user.teamTitle}</td>
	</tr>
{/foreach}
</table>


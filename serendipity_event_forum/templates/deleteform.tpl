
<h3 class="serendipity_date">{$pagetitle}</h3>
<h4 class="serendipity_title"><a href="{$ACTUALURL}">{$threadtitle}</a></h4>
<br />

<div class="serendipity_entry">
	
	{if $ERRORMSG}
		<div align="center"><span style="color: #ff0000; font-weight: bolder;">{$ERRORMSG}</span></div><br />
	{/if}
	
	{if $CANDELETE}
	<table width="100%" border="0" cellspacing="2" cellpadding="2">
		<form name="deleteform" action="{$ACTUALURL}" method="POST">
			<input type="hidden" name="serendipity[action]" value="delete" />
			<input type="hidden" name="serendipity[boardid]" value="{$boardid}" />
			<input type="hidden" name="serendipity[threadid]" value="{$threadid}" />
            <input type="hidden" name="serendipity[page]" value="{$page}" />
			<input type="hidden" name="serendipity[delete]" value="{$delete}" />
		
		
		<tr style="background-color: {$bgcolor2};">
			<td colspan="2"><div align="center"><span style="color: #0000ff; font-weight: bolder;">{$CONST.PLUGIN_FORUM_CONFIRM_DELETE_POST}</span></div></td>
		</tr>
		
		
		<tr style="background-color: {$bgcolor2};">
			<td colspan="2" height="60" align="center">
				<input type="image" src="{$relpath}/img/yes.png" style="width: 60px;" width="60" name="serendipity[yes]" value="{$CONST.YES}" /> &nbsp; 
				<input type="image" src="{$relpath}/img/no.png" style="width: 60px;" width="60" name="serendipity[no]" value="{$CONST.NO}" />
			</td>
		</tr>
		
		
		</form>
		
		
		<tr style="background-color: {$bgcolor1};">
			<td width="100" align="left" valign="top">
				<b>{$POST_AUTHORNAME}</b><br />
				<br />
			</td>
			<td width="100%" height="28" valign="top">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="100%">
							{$POST_DATE} &nbsp; <b>{$POST_TITLE}</b>
						</td>
					</tr>
					<tr>
						<td><hr /></td>
					</tr>
					<tr>
						<td>{$POST_MESSAGE}</td>
					</tr>
				</table>
			</td>
		</tr>
		
		
	</table>
	{/if}
	
</div>

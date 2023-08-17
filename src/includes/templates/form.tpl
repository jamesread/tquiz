{if !isset($excludeBox)}
<div class = "box {if isset($containerClass)}{$containerClass}{/if}">
	<h2>{$form->getTitle()}</h2>
{else}
	<h3>{$form->getTitle()}</h3>
{/if}

	<!-- FORM:{$form->getName()} (rendered by template engine) !-->
	<form enctype = "{$form->getEnctype()}" id = "{$form->getName()}" action = "{$form->getAction()}" method = "post">
		{include file = "formElements.tpl" elements=$elements}

		{foreach from = $scripts item = "script"}
			<script type = "text/javascript">
			</script>
		{/foreach}

	</form>

{if !isset($excludeBox)}
</div>
{/if}

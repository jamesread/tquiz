
<div>
{foreach from = $elements item = "element"}
	{if is_array($element)}
		{include file = "formElements.tpl" elements=$element}
	{else}
		{if $element->getType() eq 'ElementHidden'}
			<input type = "hidden" name = "{$element->getName()}" value = "{$element->getValue()}" />
		{elseif $element->getType() eq 'html'}
			{$element->getValue()}
		{elseif $element->getType() eq 'ElementButton'}
			<button value = "{$form->getName()}" name = "{$element->getName()}" type = "submit">{$element->getCaption()}</button>
		{else}
			<fieldset>
				<label for = "{$element->getName()}">{$element->getCaption()}</label>

				{$element->render()}

				{if $element->description ne ''}
				<p class = "description"><img src = "resources/images/icons/help.png" class = "imageIcon" alt = "Form element help" />{$element->description}</p>
				{/if}

				{if $element->getValidationError() ne ''}
				<p class = "formValidationError">{$element->getValidationError()}</p>
				{/if}
			</fieldset>
		{/if}
	{/if}
{/foreach}

</div>

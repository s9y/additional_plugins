<div class="shariff">
{foreach $services as $service}
    {if $service == 'facebook'}
        <a href="https://www.facebook.com/sharer/sharer.php?u={$url|escape:url}" target="_blank" rel="noopener">
            Facebook
        </a>
    {/if}
    {if $service == 'twitter'}
        <a href="https://twitter.com/intent/tweet?text={"$title $url"|escape:url}" target="_blank" rel="noopener">
            X
        </a>
    {/if}
    {if $service == 'linkedin'}
        <a href="https://www.linkedin.com/shareArticle?mini=true&title={$title|escape:url}&url={$url|escape:url}" target="_blank" rel="noopener">
            LinkedIn
        </a>
    {/if}
    {if $service == 'xing'}
        <a href="https://www.xing.com/social_plugins/share?url={$url|escape:url}" target="_blank" rel="noopener">
            Xing
        </a>
    {/if}
    {if $service == 'whatsapp'}
        <a href="whatsapp://send?text={$url|escape:url}" target="_blank" rel="noopener">
            WhatsApp
        </a>
    {/if}
    {if $service == 'telegram'}
        <a href="https://t.me/share/url?url={$url|escape:url}" target="_blank" rel="noopener">
            Telegram
        </a>
    {/if}
    {if $service == 'reddit'}
        <a href="https://reddit.com/submit?url={$url|escape:url}&title={$title|escape:url}" target="_blank" rel="noopener">
            Reddit
        </a>
    {/if}
    {if $service == 'mail'}
        <a href="mailto:?subject={$title|escape:url}&body={$url|escape:url}" target="_blank" rel="noopener">
            Mail
        </a>
    {/if}
    {if $service == 'pinterest'}
        <a href="https://pinterest.com/pin/create/button/?url={$url|escape:url}&media={$url|escape:url}&description={$title|escape:url}" target="_blank" rel="noopener">
            Pinterest
        </a>
    {/if}
{/foreach}
</div>
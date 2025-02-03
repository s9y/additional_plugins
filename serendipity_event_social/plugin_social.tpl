<div class="shariff social">
{foreach $services as $service}
    {if $service == 'facebook'}
        <a href="https://www.facebook.com/sharer/sharer.php?u={$url|escape:url}" target="_blank" rel="noopener" class="{$service}">
            Facebook
        </a>
    {/if}
    {if $service == 'twitter'}
        <a href="https://twitter.com/intent/tweet?text={"$title $url"|escape:url}" target="_blank" rel="noopener" class="{$service}">
            X
        </a>
    {/if}
    {if $service == 'linkedin'}
        <a href="https://www.linkedin.com/shareArticle?mini=true&title={$title|escape:url}&url={$url|escape:url}" target="_blank" rel="noopener" class="{$service}">
            LinkedIn
        </a>
    {/if}
    {if $service == 'xing'}
        <a href="https://www.xing.com/social/share/spi?url={$url|escape:url}" target="_blank" rel="noopener" class="{$service}">
            Xing
        </a>
    {/if}
    {if $service == 'whatsapp'}
        <a href="whatsapp://send?text={$url|escape:url}" target="_blank" rel="noopener" class="{$service}">
            WhatsApp
        </a>
    {/if}
    {if $service == 'telegram'}
        <a href="https://t.me/share/url?url={$url|escape:url}" target="_blank" rel="noopener" class="{$service}">
            Telegram
        </a>
    {/if}
    {if $service == 'reddit'}
        <a href="https://reddit.com/submit?url={$url|escape:url}&title={$title|escape:url}" target="_blank" rel="noopener" class="{$service}">
            Reddit
        </a>
    {/if}
    {if $service == 'mail'}
        <a href="mailto:?subject={$title|escape:url}&body={$url|escape:url}" target="_blank" rel="noopener" class="{$service}">
            Mail
        </a>
    {/if}
    {if $service == 'pinterest'}
        <a href="https://pinterest.com/pin/create/button/?url={$url|escape:url}&media={$url|escape:url}&description={$title|escape:url}" target="_blank" rel="noopener" class="{$service}">
            Pinterest
        </a>
    {/if}
    {if $service == 'tumblr'}
        <a href="https://tumblr.com/widgets/share/tool?canonicalUrl={$url|escape:url}" target="_blank" rel="noopener" class="{$service}">
            Tumblr
        </a>
    {/if}
    {if $service == 'diaspora'}
        <a href="https://share.diasporafoundation.org?title={$title|escape:url}&url={$url|escape:url}" target="_blank" rel="noopener" class="{$service}">
            Diaspora
        </a>
    {/if}
    {if $service == 'threema'}
        <a href="threema://compose?text={$title|escape:url}%20{$url|escape:url}" target="_blank" rel="noopener" class="{$service}">
            Threema
        </a>
    {/if}
    {if $service == 'weibo'}
        <a href="https://service.weibo.com/share/share.php?url={$url|escape:url}&title={$title|escape:url}" target="_blank" rel="noopener" class="{$service}">
            Weibo
        </a>
    {/if}
    {if $service == 'qzone'}
        <a href="https://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url={$url|escape:url}&title={$title|escape:url}" target="_blank" rel="noopener" class="{$service}">
            Qzone
        </a>
    {/if}
    {if $service == 'vk'}
        <a href="https://vk.com/share.php?url={$url|escape:url}" target="_blank" rel="noopener" class="{$service}">
            VK
        </a>
    {/if}
    {if $service == 'flipboard'}
        <a href="https://share.flipboard.com/bookmarklet/popout?v=2&title={$title|escape:url}&url={$url|escape:url}" target="_blank" rel="noopener" class="{$service}">
            Flipboard
        </a>
    {/if}
    {if $service == 'buffer'}
        <a href="https://buffer.com/add?text={$title|escape:url}&url={$url|escape:url}" target="_blank" rel="noopener" class="{$service}">
            Buffer
        </a>
    {/if}
    {if $service == 'mastodon'}
        <a href="https://toot.kytta.dev/?text={"$title $url"|escape:url}" target="_blank" rel="noopener" class="{$service}">
            Mastodon
        </a>
    {/if}
    {if $service == 'bluesky'}
        <a href=" https://bsky.app/intent/compose?text={"$title $url"|escape:url}" target="_blank" rel="noopener" class="{$service}">
            Bluesky
        </a>
    {/if}
{/foreach}
</div>
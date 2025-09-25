<div class="shariff social {$theme} size_{$size}">
{foreach $services as $service}
    {if $service == 'facebook'}
        <a href="https://www.facebook.com/sharer/sharer.php?u={$url|escape:url}" target="_blank" rel="noopener" class="{$service}" title="{$CONST.PLUGIN_EVENT_SOCIAL_SHARE_TITLE|sprintf:Facebook}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="currentColor" d="M512 256C512 114.6 397.4 0 256 0S0 114.6 0 256C0 376 82.7 476.8 194.2 504.5V334.2H141.4V256h52.8V222.3c0-87.1 39.4-127.5 125-127.5c16.2 0 44.2 3.2 55.7 6.4V172c-6-.6-16.5-1-29.6-1c-42 0-58.2 15.9-58.2 57.2V256h83.6l-14.4 78.2H287V510.1C413.8 494.8 512 386.9 512 256h0z"/></svg>
            {if $size == "standard"}{$CONST.PLUGIN_EVENT_SOCIAL_SHARE_ACTION}{/if}
        </a>
    {/if}
    {if $service == 'twitter'}
        <a href="https://twitter.com/intent/tweet?text={$title|escape:url}&url={$url|escape:url}{if $twitter_via_tag}&via=$twitter_via_tag{/if}" target="_blank" rel="noopener" class="{$service}" title="{$CONST.PLUGIN_EVENT_SOCIAL_SHARE_TITLE|sprintf:X}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="currentColor" d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"/></svg>
            {if $size == "standard"}Tweet{/if}
        </a>
    {/if}
    {if $service == 'linkedin'}
        <a href="https://www.linkedin.com/shareArticle?mini=true&title={$title|escape:url}&url={$url|escape:url}" target="_blank" rel="noopener" class="{$service}" title="{$CONST.PLUGIN_EVENT_SOCIAL_SHARE_TITLE|sprintf:LinkedIn}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="currentColor" d="M416 32H31.9C14.3 32 0 46.5 0 64.3v383.4C0 465.5 14.3 480 31.9 480H416c17.6 0 32-14.5 32-32.3V64.3c0-17.8-14.4-32.3-32-32.3zM135.4 416H69V202.2h66.5V416zm-33.2-243c-21.3 0-38.5-17.3-38.5-38.5S80.9 96 102.2 96c21.2 0 38.5 17.3 38.5 38.5 0 21.3-17.2 38.5-38.5 38.5zm282.1 243h-66.4V312c0-24.8-.5-56.7-34.5-56.7-34.6 0-39.9 27-39.9 54.9V416h-66.4V202.2h63.7v29.2h.9c8.9-16.8 30.6-34.5 62.9-34.5 67.2 0 79.7 44.3 79.7 101.9V416z"/></svg>
            {if $size == "standard"}{$CONST.PLUGIN_EVENT_SOCIAL_SHARE_ACTION}{/if}
        </a>
    {/if}
    {if $service == 'xing'}
        <a href="https://www.xing.com/social/share/spi?url={$url|escape:url}" target="_blank" rel="noopener" class="{$service}" title="{$CONST.PLUGIN_EVENT_SOCIAL_SHARE_TITLE|sprintf:XING}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="currentColor" d="M162.7 210c-1.8 3.3-25.2 44.4-70.1 123.5-4.9 8.3-10.8 12.5-17.7 12.5H9.8c-7.7 0-12.1-7.5-8.5-14.4l69-121.3c.2 0 .2-.1 0-.3l-43.9-75.6c-4.3-7.8 .3-14.1 8.5-14.1H100c7.3 0 13.3 4.1 18 12.2l44.7 77.5zM382.6 46.1l-144 253v.3L330.2 466c3.9 7.1 .2 14.1-8.5 14.1h-65.2c-7.6 0-13.6-4-18-12.2l-92.4-168.5c3.3-5.8 51.5-90.8 144.8-255.2 4.6-8.1 10.4-12.2 17.5-12.2h65.7c8 0 12.3 6.7 8.5 14.1z"/></svg>
            {if $size == "standard"}{$CONST.PLUGIN_EVENT_SOCIAL_SHARE_ACTION}{/if}
        </a>
    {/if}
    {if $service == 'whatsapp'}
        <a href="whatsapp://send?text={$url|escape:url}" target="_blank" rel="noopener" class="{$service}" title="{$CONST.PLUGIN_EVENT_SOCIAL_SHARE_TITLE|sprintf:WhatsApp}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="currentColor" d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7 .9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/></svg>
            {if $size == "standard"}{$CONST.PLUGIN_EVENT_SOCIAL_SHARE_ACTION}{/if}
        </a>
    {/if}
    {if $service == 'telegram'}
        <a href="https://t.me/share/url?url={$url|escape:url}" target="_blank" rel="noopener" class="{$service}" title="{$CONST.PLUGIN_EVENT_SOCIAL_SHARE_TITLE|sprintf:Telegram}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="currentColor" d="M248 8C111 8 0 119 0 256S111 504 248 504 496 393 496 256 385 8 248 8zM363 176.7c-3.7 39.2-19.9 134.4-28.1 178.3-3.5 18.6-10.3 24.8-16.9 25.4-14.4 1.3-25.3-9.5-39.3-18.7-21.8-14.3-34.2-23.2-55.3-37.2-24.5-16.1-8.6-25 5.3-39.5 3.7-3.8 67.1-61.5 68.3-66.7 .2-.7 .3-3.1-1.2-4.4s-3.6-.8-5.1-.5q-3.3 .7-104.6 69.1-14.8 10.2-26.9 9.9c-8.9-.2-25.9-5-38.6-9.1-15.5-5-27.9-7.7-26.8-16.3q.8-6.7 18.5-13.7 108.4-47.2 144.6-62.3c68.9-28.6 83.2-33.6 92.5-33.8 2.1 0 6.6 .5 9.6 2.9a10.5 10.5 0 0 1 3.5 6.7A43.8 43.8 0 0 1 363 176.7z"/></svg>
            {if $size == "standard"}{$CONST.PLUGIN_EVENT_SOCIAL_SHARE_ACTION}{/if}
        </a>
    {/if}
    {if $service == 'reddit'}
        <a href="https://reddit.com/submit?url={$url|escape:url}&title={$title|escape:url}" target="_blank" rel="noopener" class="{$service}" title="{$CONST.PLUGIN_EVENT_SOCIAL_SHARE_TITLE|sprintf:Reddit}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="currentColor" d="M0 256C0 114.6 114.6 0 256 0S512 114.6 512 256s-114.6 256-256 256L37.1 512c-13.7 0-20.5-16.5-10.9-26.2L75 437C28.7 390.7 0 326.7 0 256zM349.6 153.6c23.6 0 42.7-19.1 42.7-42.7s-19.1-42.7-42.7-42.7c-20.6 0-37.8 14.6-41.8 34c-34.5 3.7-61.4 33-61.4 68.4l0 .2c-37.5 1.6-71.8 12.3-99 29.1c-10.1-7.8-22.8-12.5-36.5-12.5c-33 0-59.8 26.8-59.8 59.8c0 24 14.1 44.6 34.4 54.1c2 69.4 77.6 125.2 170.6 125.2s168.7-55.9 170.6-125.3c20.2-9.6 34.1-30.2 34.1-54c0-33-26.8-59.8-59.8-59.8c-13.7 0-26.3 4.6-36.4 12.4c-27.4-17-62.1-27.7-100-29.1l0-.2c0-25.4 18.9-46.5 43.4-49.9l0 0c4.4 18.8 21.3 32.8 41.5 32.8zM177.1 246.9c16.7 0 29.5 17.6 28.5 39.3s-13.5 29.6-30.3 29.6s-31.4-8.8-30.4-30.5s15.4-38.3 32.1-38.3zm190.1 38.3c1 21.7-13.7 30.5-30.4 30.5s-29.3-7.9-30.3-29.6c-1-21.7 11.8-39.3 28.5-39.3s31.2 16.6 32.1 38.3zm-48.1 56.7c-10.3 24.6-34.6 41.9-63 41.9s-52.7-17.3-63-41.9c-1.2-2.9 .8-6.2 3.9-6.5c18.4-1.9 38.3-2.9 59.1-2.9s40.7 1 59.1 2.9c3.1 .3 5.1 3.6 3.9 6.5z"/></svg>
            {if $size == "standard"}{$CONST.PLUGIN_EVENT_SOCIAL_SHARE_ACTION}{/if}
        </a>
    {/if}
    {if $service == 'mail'}
        <a href="mailto:?subject={$title|escape:url}&body={$url|escape:url}" target="_blank" rel="noopener" class="{$service}" title="{$CONST.PLUGIN_EVENT_SOCIAL_SHARE_TITLE_MAIL}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="currentColor" d="M64 112c-8.8 0-16 7.2-16 16l0 22.1L220.5 291.7c20.7 17 50.4 17 71.1 0L464 150.1l0-22.1c0-8.8-7.2-16-16-16L64 112zM48 212.2L48 384c0 8.8 7.2 16 16 16l384 0c8.8 0 16-7.2 16-16l0-171.8L322 328.8c-38.4 31.5-93.7 31.5-132 0L48 212.2zM0 128C0 92.7 28.7 64 64 64l384 0c35.3 0 64 28.7 64 64l0 256c0 35.3-28.7 64-64 64L64 448c-35.3 0-64-28.7-64-64L0 128z"/></svg>
            {if $size == "standard"}Mail{/if}
        </a>
    {/if}
    {if $service == 'pinterest'}
        <a href="https://pinterest.com/pin/create/button/?url={$url|escape:url}&media={$url|escape:url}&description={$title|escape:url}" target="_blank" rel="noopener" class="{$service}" title="{$CONST.PLUGIN_EVENT_SOCIAL_SHARE_TITLE_PINTEREST}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="currentColor" d="M496 256c0 137-111 248-248 248-25.6 0-50.2-3.9-73.4-11.1 10.1-16.5 25.2-43.5 30.8-65 3-11.6 15.4-59 15.4-59 8.1 15.4 31.7 28.5 56.8 28.5 74.8 0 128.7-68.8 128.7-154.3 0-81.9-66.9-143.2-152.9-143.2-107 0-163.9 71.8-163.9 150.1 0 36.4 19.4 81.7 50.3 96.1 4.7 2.2 7.2 1.2 8.3-3.3 .8-3.4 5-20.3 6.9-28.1 .6-2.5 .3-4.7-1.7-7.1-10.1-12.5-18.3-35.3-18.3-56.6 0-54.7 41.4-107.6 112-107.6 60.9 0 103.6 41.5 103.6 100.9 0 67.1-33.9 113.6-78 113.6-24.3 0-42.6-20.1-36.7-44.8 7-29.5 20.5-61.3 20.5-82.6 0-19-10.2-34.9-31.4-34.9-24.9 0-44.9 25.7-44.9 60.2 0 22 7.4 36.8 7.4 36.8s-24.5 103.8-29 123.2c-5 21.4-3 51.6-.9 71.2C65.4 450.9 0 361.1 0 256 0 119 111 8 248 8s248 111 248 248z"/></svg>
            {if $size == "standard"}Pin it{/if}
        </a>
    {/if}
    {if $service == 'tumblr'}
        <a href="https://tumblr.com/widgets/share/tool?canonicalUrl={$url|escape:url}" target="_blank" rel="noopener" class="{$service}" title="{$CONST.PLUGIN_EVENT_SOCIAL_SHARE_TITLE|sprintf:Tumblr}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="currentColor" d="M309.8 480.3c-13.6 14.5-50 31.7-97.4 31.7-120.8 0-147-88.8-147-140.6v-144H17.9c-5.5 0-10-4.5-10-10v-68c0-7.2 4.5-13.6 11.3-16 62-21.8 81.5-76 84.3-117.1 .8-11 6.5-16.3 16.1-16.3h70.9c5.5 0 10 4.5 10 10v115.2h83c5.5 0 10 4.4 10 9.9v81.7c0 5.5-4.5 10-10 10h-83.4V360c0 34.2 23.7 53.6 68 35.8 4.8-1.9 9-3.2 12.7-2.2 3.5 .9 5.8 3.4 7.4 7.9l22 64.3c1.8 5 3.3 10.6-.4 14.5z"/></svg>
            {if $size == "standard"}Tumblr{/if}
        </a>
    {/if}
    {if $service == 'diaspora'}
        <a href="https://share.diasporafoundation.org?title={$title|escape:url}&url={$url|escape:url}" target="_blank" rel="noopener" class="{$service}" title="{$CONST.PLUGIN_EVENT_SOCIAL_SHARE_TITLE|sprintf:Diaspora}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="currentColor" d="M251.6 354.6c-1.4 0-88 119.9-88.7 119.9S76.3 414 76 413.3s86.6-125.7 86.6-127.4c0-2.2-129.6-44-137.6-47.1-1.3-.5 31.4-101.8 31.7-102.1 .6-.7 144.4 47 145.5 47 .4 0 .9-.6 1-1.3 .4-2 1-148.6 1.7-149.6 .8-1.2 104.5-.7 105.1-.3 1.5 1 3.5 156.1 6.1 156.1 1.4 0 138.7-47 139.3-46.3 .8 .9 31.9 102.2 31.5 102.6-.9 .9-140.2 47.1-140.6 48.8-.3 1.4 82.8 122.1 82.5 122.9s-85.5 63.5-86.3 63.5c-1-.2-89-125.5-90.9-125.5z"/></svg>
            {if $size == "standard"}{$CONST.PLUGIN_EVENT_SOCIAL_SHARE_ACTION}{/if}
        </a>
    {/if}
    {if $service == 'threema'}
        <a href="threema://compose?text={$title|escape:url}%20{$url|escape:url}" target="_blank" rel="noopener" class="{$service}" title="{$CONST.PLUGIN_EVENT_SOCIAL_SHARE_TITLE|sprintf:Threema}">
           <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 1024 1024"><g style="fill:currentColor"><rect width="1024" height="1024" fill="transparent" fill-rule="evenodd" class="fills" rx="50" ry="50" style="fill:transparent"/><path d="M287.623 952.604 31.125 1024l54.818-244.131C31.653 700.246 0 604.54 0 501.604 0 224.57 229.233 0 512 0s512 224.57 512 501.604c0 277.035-229.233 501.604-512 501.604-80.477 0-156.62-18.191-224.377-50.604m79.125-492.646h-5.707c-12.892 0-23.344 11.636-23.344 25.99v227.896c0 14.353 10.452 25.99 23.344 25.99H662.95c12.892 0 23.343-11.637 23.343-25.99V485.948c0-14.354-10.451-25.99-23.343-25.99h-5.707V395.37c0-89.094-64.983-161.468-145.316-161.468-80.196 0-145.18 72.373-145.18 161.468zm232.393 0H424.842v-64.576c0-53.458 38.99-96.892 87.108-96.892 48.2 0 87.19 43.434 87.19 96.892zM769.9 847.99c0-30.89-25.043-55.99-56.001-55.99-30.906 0-55.95 25.1-55.95 55.99 0 30.95 25.044 56.01 55.95 56.01 30.958 0 56.001-25.06 56.001-56.01m-403.9 0c0-30.89-25.043-55.99-56.002-55.99-30.906 0-55.95 25.1-55.95 55.99 0 30.95 25.044 56.01 55.95 56.01C340.957 904 366 878.94 366 847.99m201.95 0c0-30.89-25.043-55.99-56.001-55.99-30.907 0-55.95 25.1-55.95 55.99 0 30.95 25.043 56.01 55.949 56.01 30.959 0 56.002-25.06 56.002-56.01" class="fills" style="fill:currentColor;fill-opacity:1"/></g></svg>
           {if $size == "standard"}{$CONST.PLUGIN_EVENT_SOCIAL_SHARE_ACTION}{/if}
        </a>
    {/if}
    {if $service == 'weibo'}
        <a href="https://service.weibo.com/share/share.php?url={$url|escape:url}&title={$title|escape:url}" target="_blank" rel="noopener" class="{$service}" title="{$CONST.PLUGIN_EVENT_SOCIAL_SHARE_TITLE|sprintf:Weibo}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="currentColor" d="M407 177.6c7.6-24-13.4-46.8-37.4-41.7-22 4.8-28.8-28.1-7.1-32.8 50.1-10.9 92.3 37.1 76.5 84.8-6.8 21.2-38.8 10.8-32-10.3zM214.8 446.7C108.5 446.7 0 395.3 0 310.4c0-44.3 28-95.4 76.3-143.7C176 67 279.5 65.8 249.9 161c-4 13.1 12.3 5.7 12.3 6 79.5-33.6 140.5-16.8 114 51.4-3.7 9.4 1.1 10.9 8.3 13.1 135.7 42.3 34.8 215.2-169.7 215.2zm143.7-146.3c-5.4-55.7-78.5-94-163.4-85.7-84.8 8.6-148.8 60.3-143.4 116s78.5 94 163.4 85.7c84.8-8.6 148.8-60.3 143.4-116zM347.9 35.1c-25.9 5.6-16.8 43.7 8.3 38.3 72.3-15.2 134.8 52.8 111.7 124-7.4 24.2 29.1 37 37.4 12 31.9-99.8-55.1-195.9-157.4-174.3zm-78.5 311c-17.1 38.8-66.8 60-109.1 46.3-40.8-13.1-58-53.4-40.3-89.7 17.7-35.4 63.1-55.4 103.4-45.1 42 10.8 63.1 50.2 46 88.5zm-86.3-30c-12.9-5.4-30 .3-38 12.9-8.3 12.9-4.3 28 8.6 34 13.1 6 30.8 .3 39.1-12.9 8-13.1 3.7-28.3-9.7-34zm32.6-13.4c-5.1-1.7-11.4 .6-14.3 5.4-2.9 5.1-1.4 10.6 3.7 12.9 5.1 2 11.7-.3 14.6-5.4 2.8-5.2 1.1-10.9-4-12.9z"/></svg>
            {if $size == "standard"}{$CONST.PLUGIN_EVENT_SOCIAL_SHARE_ACTION}{/if}
        </a>
    {/if}
    {if $service == 'qzone'}
        <a href="https://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url={$url|escape:url}&title={$title|escape:url}" target="_blank" rel="noopener" class="{$service}" title="{$CONST.PLUGIN_EVENT_SOCIAL_SHARE_TITLE|sprintf:Qzone}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="currentColor" d="M433.8 420.4c-11.5 1.4-44.9-52.7-44.9-52.7 0 31.3-16.1 72.2-51.1 101.8 16.8 5.2 54.8 19.2 45.8 34.4-7.3 12.3-125.5 7.9-159.6 4-34.1 3.8-152.3 8.3-159.6-4-9-15.3 28.9-29.2 45.8-34.4-34.9-29.5-51.1-70.4-51.1-101.8 0 0-33.3 54.1-44.9 52.7-5.4-.7-12.4-29.6 9.3-99.7 10.3-33 22-60.5 40.1-105.8C60.7 98.1 109 0 224 0c113.7 0 163.2 96.1 160.3 215 18.1 45.2 29.9 72.9 40.1 105.8 21.8 70.1 14.7 99.1 9.3 99.7z"/></svg>
            {if $size == "standard"}{$CONST.PLUGIN_EVENT_SOCIAL_SHARE_ACTION}{/if}
        </a>
    {/if}
    {if $service == 'vk'}
        <a href="https://vk.com/share.php?url={$url|escape:url}" target="_blank" rel="noopener" class="{$service}" title="{$CONST.PLUGIN_EVENT_SOCIAL_SHARE_TITLE|sprintf:VK}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="currentColor" d="M31.5 63.5C0 95 0 145.7 0 247V265C0 366.3 0 417 31.5 448.5C63 480 113.7 480 215 480H233C334.3 480 385 480 416.5 448.5C448 417 448 366.3 448 265V247C448 145.7 448 95 416.5 63.5C385 32 334.3 32 233 32H215C113.7 32 63 32 31.5 63.5zM75.6 168.3H126.7C128.4 253.8 166.1 290 196 297.4V168.3H244.2V242C273.7 238.8 304.6 205.2 315.1 168.3H363.3C359.3 187.4 351.5 205.6 340.2 221.6C328.9 237.6 314.5 251.1 297.7 261.2C316.4 270.5 332.9 283.6 346.1 299.8C359.4 315.9 369 334.6 374.5 354.7H321.4C316.6 337.3 306.6 321.6 292.9 309.8C279.1 297.9 262.2 290.4 244.2 288.1V354.7H238.4C136.3 354.7 78 284.7 75.6 168.3z"/></svg>
            {if $size == "standard"}{$CONST.PLUGIN_EVENT_SOCIAL_SHARE_ACTION}{/if}
        </a>
    {/if}
    {if $service == 'flipboard'}
        <a href="https://share.flipboard.com/bookmarklet/popout?v=2&title={$title|escape:url}&url={$url|escape:url}" target="_blank" rel="noopener" class="{$service}" title="{$CONST.PLUGIN_EVENT_SOCIAL_SHARE_TITLE|sprintf:Flipboard}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="currentColor" d="M0 32v448h448V32H0zm358.4 179.2h-89.6v89.6h-89.6v89.6H89.6V121.6h268.8v89.6z"/></svg>
            {if $size == "standard"}Flip it{/if}
        </a>
    {/if}
    {if $service == 'buffer'}
        <a href="https://buffer.com/add?text={$title|escape:url}&url={$url|escape:url}" target="_blank" rel="noopener" class="{$service}" title="{$CONST.PLUGIN_EVENT_SOCIAL_SHARE_TITLE|sprintf:Buffer}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="currentColor" d="M427.8 380.7l-196.5 97.8a18.6 18.6 0 0 1 -14.7 0L20.2 380.7c-4-2-4-5.3 0-7.3L67.2 350a18.7 18.7 0 0 1 14.7 0l134.8 67a18.5 18.5 0 0 0 14.7 0l134.8-67a18.6 18.6 0 0 1 14.7 0l47.1 23.4c4.1 2 4.1 5.2 0 7.2zm0-136.5l-47.1-23.4a18.6 18.6 0 0 0 -14.7 0l-134.8 67.1a18.7 18.7 0 0 1 -14.7 0L81.9 220.7a18.7 18.7 0 0 0 -14.7 0l-47.1 23.4c-4 2-4 5.3 0 7.3l196.5 97.8a18.6 18.6 0 0 0 14.7 0l196.5-97.8c4.1-2 4.1-5.3 0-7.3zM20.2 130.4l196.5 90.3a20.1 20.1 0 0 0 14.7 0l196.5-90.3c4-1.9 4-4.9 0-6.7L231.3 33.4a19.9 19.9 0 0 0 -14.7 0l-196.5 90.3c-4.1 1.9-4.1 4.9 0 6.7z"/></svg>
            {if $size == "standard"}{$CONST.PLUGIN_EVENT_SOCIAL_SHARE_ACTION}{/if}
        </a>
    {/if}
    {if $service == 'mastodon'}
        <a href="https://tootpick.org/#text={"$title $url{if $mastodon_via_tag} $mastodon_via_tag{/if}"|escape:url}" target="_blank" rel="noopener" class="{$service}" title="{$CONST.PLUGIN_EVENT_SOCIAL_SHARE_TITLE|sprintf:Mastodon}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="currentColor" d="M433 179.1c0-97.2-63.7-125.7-63.7-125.7-62.5-28.7-228.6-28.4-290.5 0 0 0-63.7 28.5-63.7 125.7 0 115.7-6.6 259.4 105.6 289.1 40.5 10.7 75.3 13 103.3 11.4 50.8-2.8 79.3-18.1 79.3-18.1l-1.7-36.9s-36.3 11.4-77.1 10.1c-40.4-1.4-83-4.4-89.6-54a102.5 102.5 0 0 1 -.9-13.9c85.6 20.9 158.7 9.1 178.8 6.7 56.1-6.7 105-41.3 111.2-72.9 9.8-49.8 9-121.5 9-121.5zm-75.1 125.2h-46.6v-114.2c0-49.7-64-51.6-64 6.9v62.5h-46.3V197c0-58.5-64-56.6-64-6.9v114.2H90.2c0-122.1-5.2-147.9 18.4-175 25.9-28.9 79.8-30.8 103.8 6.1l11.6 19.5 11.6-19.5c24.1-37.1 78.1-34.8 103.8-6.1 23.7 27.3 18.4 53 18.4 175z"/></svg>
            {if $size == "standard"}Toot{/if}
        </a>
    {/if}
    {if $service == 'bluesky'}
        <a href="https://bsky.app/intent/compose?text={"$title $url{if $bluesky_via_tag} $bluesky_via_tag{/if}"|escape:url}" target="_blank" rel="noopener" class="{$service}" title="{$CONST.PLUGIN_EVENT_SOCIAL_SHARE_TITLE|sprintf:Bluesky}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="currentColor" d="M111.8 62.2C170.2 105.9 233 194.7 256 242.4c23-47.6 85.8-136.4 144.2-180.2c42.1-31.6 110.3-56 110.3 21.8c0 15.5-8.9 130.5-14.1 149.2C478.2 298 412 314.6 353.1 304.5c102.9 17.5 129.1 75.5 72.5 133.5c-107.4 110.2-154.3-27.6-166.3-62.9l0 0c-1.7-4.9-2.6-7.8-3.3-7.8s-1.6 3-3.3 7.8l0 0c-12 35.3-59 173.1-166.3 62.9c-56.5-58-30.4-116 72.5-133.5C100 314.6 33.8 298 15.7 233.1C10.4 214.4 1.5 99.4 1.5 83.9c0-77.8 68.2-53.4 110.3-21.8z"/></svg>
            {if $size == "standard"}Post{/if}
        </a>
    {/if}
    {if $service == 'pocket'}
        <a href="https://getpocket.com/save?title={$title|escape:url}&url={$url|escape:url}" target="_blank" rel="noopener" class="{$service}" title="{$CONST.PLUGIN_EVENT_SOCIAL_SHARE_TITLE_POCKET}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="currentColor" d="M407.6 64h-367C18.5 64 0 82.5 0 104.6v135.2C0 364.5 99.7 464 224.2 464c124 0 223.8-99.5 223.8-224.2V104.6c0-22.4-17.7-40.6-40.4-40.6zm-162 268.5c-12.4 11.8-31.4 11.1-42.4 0C89.5 223.6 88.3 227.4 88.3 209.3c0-16.9 13.8-30.7 30.7-30.7 17 0 16.1 3.8 105.2 89.3 90.6-86.9 88.6-89.3 105.5-89.3 16.9 0 30.7 13.8 30.7 30.7 0 17.8-2.9 15.7-114.8 123.2z"/></svg>
            {if $size == "standard"}Pocket{/if}
        </a>
    {/if}
{/foreach}
</div>
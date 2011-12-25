<div class="serendipityAuthorProfile">
<strong>{$userProfileTitle} - {$userProfile.realname}</strong>
<br />

<dl>
{if $userProfile.show_email == "true"}
    <dt>{$userProfileLocalProperties.email.desc}</dt>
    <dd><a href="mailto:{$userProfile.email|escape:"hex"}">{$userProfile.email|escape:"hexentity"}</a></dd>
{/if}
{if $userProfile.birthday and $userProfile.show_birthday == "true"}
    <dt>{$userProfileProperties.birthday.desc}</dt>
    <dd>{$userProfile.birthday|@formatTime:DATE_FORMAT_ENTRY}</dd>
{/if}
{if $userProfile.url and $userProfile.show_url == "true"}
    <dt>{$userProfileProperties.url.desc}</dt>
    <dd>{$userProfile.url}</dd>
{/if}
{if $userProfile.city and $userProfile.show_city == "true"}
    <dt>{$userProfileProperties.city.desc}</dt>
    <dd>{$userProfile.city}</dd>
{/if}
{if $userProfile.country and $userProfile.show_country == "true"}
    <dt>{$userProfileProperties.country.desc}</dt>
    <dd>{$userProfile.country}</dd>
{/if}
{if $userProfile.occupation and $userProfile.show_occupation == "true"}
    <dt>{$userProfileProperties.occupation.desc}</dt>
    <dd>{$userProfile.occupation}</dd>
{/if}
{if $userProfile.hobbies and $userProfile.show_hobbies == "true"}
    <dt>{$userProfileProperties.hobbies.desc}</dt>
    <dd>{$userProfile.hobbies}</dd>
{/if}
{if $userProfile.yahoo and $userProfile.show_yahoo == "true"}
    <dt>{$userProfileProperties.yahoo.desc}</dt>
    <dd>{$userProfile.yahoo}</dd>
{/if}
{if $userProfile.aim and $userProfile.show_aim == "true"}
    <dt>{$userProfileProperties.aim.desc}</dt>
    <dd>{$userProfile.aim}</dd>
{/if}
{if $userProfile.jabber and $userProfile.show_jabber == "true"}
    <dt>{$userProfileProperties.jabber.desc}</dt>
    <dd>{$userProfile.jabber}</dd>
{/if}
{if $userProfile.icq and $userProfile.show_icq == "true"}
    <dt>{$userProfileProperties.icq.desc}</dt>
    <dd>{$userProfile.icq}</dd>
{/if}
{if $userProfile.msn and $userProfile.show_msn == "true"}
    <dt>{$userProfileProperties.msn.desc}</dt>
    <dd>{$userProfile.msn}</dd>
{/if}
{if $userProfile.skype and $userProfile.show_skype == "true"}
    <dt>{$userProfileProperties.skype.desc}</dt>
    <dd>{$userProfile.skype}</dd>
{/if}
</dl>
</div>
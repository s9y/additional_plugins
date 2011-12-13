                  <div class="serendipity_amazonchr_body">
                   {if $plugin_amazonchooser_page eq 'Search'}
                        {if isset($thingy.strings.mediumurl)}
                            <div class="serendipity_amazonchr_image">
                               <a href="{$plugin_amazonchooser_select_url}{$thingy.strings.ASIN}"><img class="serendipity_amazonchr_pic" src="{$thingy.strings.mediumurl}" /></a>
                            </div>
                        {/if}
                     <div class="serendipity_amazonchr_block">
                        <div class="serendipity_amazonchr_title"><a href="{$plugin_amazonchooser_select_url}{$thingy.strings.ASIN}">{$thingy.strings.title} <span class="serendipity_amazonchr_productgroup">({$thingy.ITEMATTRIBUTES.ITEMATTRIBUTES_PRODUCTGROUP})</span></a></div>
                        {if !isset($thingy.strings.mediumurl)}<div class="serendipity_amazonchr_noimage">({$CONST.PLUGIN_EVENT_AMAZONCHOOSER_NOIMAGE})</div>{/if}
                        <div class="serendipity_amazonchr_detail"><a href="{$thingy.strings.DETAILPAGEURL}" target="_new">{$CONST.PLUGIN_EVENT_AMAZONCHOOSER_DISTINCTURL}</a></div>
                   {elseif $plugin_amazonchooser_page eq 'Lookup'}
                        {if isset($thingy.strings.mediumurl)}
                           <div class="serendipity_amazonchr_image">
                             <img border="0" src="{$thingy.strings.mediumurl}" />
                           </div>
                        {/if}
                     <div class="serendipity_amazonchr_block">
                        <div class="serendipity_amazonchr_title">{$thingy.strings.title} <span class="serendipity_amazonchr_productgroup">({$thingy.ITEMATTRIBUTES.ITEMATTRIBUTES_PRODUCTGROUP})</span></div>
                        {if !isset($thingy.strings.mediumurl)}<div class="serendipity_amazonchr_noimage">({$CONST.PLUGIN_EVENT_AMAZONCHOOSER_NOIMAGE})</div>{/if}   
                        <div class="serendipity_amazonchr_detail"><a href="{$thingy.strings.DETAILPAGEURL}" target="_new">{$CONST.PLUGIN_EVENT_AMAZONCHOOSER_DISTINCTURL}</a></div>
                     {else}
                        {if isset($thingy.strings.mediumurl)}
                           <div class="serendipity_amazonchr_image">
                              <a href="{$thingy.strings.DETAILPAGEURL}" target="_new"><img class="serendipity_amazonchr_pic" src="{$thingy.strings.mediumurl}" /></a>
                           </div>
                        {/if}
                     <div class="serendipity_amazonchr_block">
                         <div class="serendipity_amazonchr_title">{$thingy.strings.title} <span class="serendipity_amazonchr_productgroup">({$thingy.ITEMATTRIBUTES.ITEMATTRIBUTES_PRODUCTGROUP})</span></div>
                         {if !isset($thingy.strings.mediumurl)}<div class="serendipity_amazonchr_noimage">({$CONST.PLUGIN_EVENT_AMAZONCHOOSER_NOIMAGE})</div>{/if}   
                         <div class="serendipity_amazonchr_detail"><a href="{$thingy.strings.DETAILPAGEURL}" target="_new">{$CONST.PLUGIN_EVENT_AMAZONCHOOSER_DISTINCTURL}</a></div>
                   {/if}
                     {if isset($thingy.strings.author)}
                      <div class="serendipity_amazonchr_attr" id="amazonchr_author">{$CONST.PLUGIN_EVENT_AMAZONCHOOSER_AUTHOR}: {$thingy.strings.author}</div>
                     {/if}
                     {if isset($thingy.strings.director)}
                      <div class="serendipity_amazonchr_attr" id="amazonchr_director">{$CONST.PLUGIN_EVENT_AMAZONCHOOSER_DIRECTOR}: {$thingy.strings.director}</div>
                     {/if}
                     {if isset($thingy.strings.actor)}
                      <div class="serendipity_amazonchr_attr" id="amazonchr_starring">{$CONST.PLUGIN_EVENT_AMAZONCHOOSER_STARRING}: {$thingy.strings.actor}</div>
                     {/if}
                     {if isset($thingy.strings.artist)}
                      <div class="serendipity_amazonchr_attr" id="amazonchr_artists">{$CONST.PLUGIN_EVENT_AMAZONCHOOSER_ARTISTS}: {$thingy.strings.artist}</div>
                     {/if}
                     {if isset($thingy.strings.artist)}
                      <div class="serendipity_amazonchr_attr" id="amazonchr_productlanguage">{$CONST.PLUGIN_EVENT_AMAZONCHOOSER_PRODUCTLANGUAGE}: {$thingy.strings.artist}</div>
                     {/if}
                     {if isset($thingy.strings.manufacturer)}
                      <div class="serendipity_amazonchr_attr" id="amazonchr_manufacturer">{$CONST.PLUGIN_EVENT_AMAZONCHOOSER_MANUFACTURER}: {$thingy.strings.manufacturer}</div>
                     {/if}
                     {if isset($thingy.strings.distributor)}
                      <div class="serendipity_amazonchr_attr" id="amazonchr_distributor">{$CONST.PLUGIN_EVENT_AMAZONCHOOSER_DISTRIBUTOR}: {$thingy.strings.distributor}</div>
                     {/if}
                     {if isset($thingy.strings.publisher)}
                      <div class="serendipity_amazonchr_attr" id="amazonchr_publisher">{$CONST.PLUGIN_EVENT_AMAZONCHOOSER_PUBLISHER}: {$thingy.strings.publisher}</div>
                     {/if}
                     {if isset($thingy.strings.brand)}
                      <div class="serendipity_amazonchr_attr" id="amazonchr_brand">{$CONST.PLUGIN_EVENT_AMAZONCHOOSER_BRAND}: {$thingy.strings.brand}</div>
                     {/if}
                     {if isset($thingy.strings.model)}
                      <div class="serendipity_amazonchr_attr" id="amazonchr_model">{$CONST.PLUGIN_EVENT_AMAZONCHOOSER_MODEL}: {$thingy.strings.model}</div>
                     {/if}
                     {if isset($thingy.strings.releasedate)}
                      <div class="serendipity_amazonchr_attr" id="amazonchr_releasedate">{$CONST.PLUGIN_EVENT_AMAZONCHOOSER_RELEASED}: {$thingy.strings.releasedate}</div>
                     {/if}
                     {if isset($thingy.strings.publicationdate)}
                      <div class="serendipity_amazonchr_attr" id="amazonchr_publicationdate">{$CONST.PLUGIN_EVENT_AMAZONCHOOSER_PUBLISHED}: {$thingy.strings.publicationdate}</div>
                     {/if}
                     {if isset($thingy.strings.format)}
                      <div class="serendipity_amazonchr_attr" id="amazonchr_format">{$CONST.PLUGIN_EVENT_AMAZONCHOOSER_FORMAT}: {$thingy.strings.format}</div>
                     {/if}
                     {if isset($thingy.strings.platform)}
                      <div class="serendipity_amazonchr_attr" id="amazonchr_platform">{$CONST.PLUGIN_EVENT_AMAZONCHOOSER_PLATFORM}: {$thingy.strings.platform}</div>
                     {/if}
                     {if isset($thingy.strings.genre)}
                      <div class="serendipity_amazonchr_attr" id="amazonchr_genre">{$CONST.PLUGIN_EVENT_AMAZONCHOOSER_GENRE}: {$thingy.strings.genre}</div>
                     {/if}
                     {if isset($thingy.strings.numberofpages)}
                      <div class="serendipity_amazonchr_attr" id="amazonchr_numberofpages">{$CONST.PLUGIN_EVENT_AMAZONCHOOSER_NUMPAGES}: {$thingy.strings.numberofpages}</div>
                     {/if}
                     {if isset($thingy.strings.numberofdiscs)}
                      <div class="serendipity_amazonchr_attr" id="amazonchr_numberofdiscs">{$CONST.PLUGIN_EVENT_AMAZONCHOOSER_NUMDISKS}: {$thingy.strings.numberofdiscs}</div>
                     {/if}
                     {if isset($thingy.strings.running)}
                      <div class="serendipity_amazonchr_attr" id="amazonchr_running">{$CONST.PLUGIN_EVENT_AMAZONCHOOSER_RUNNING}: {$thingy.strings.running}</div>
                     {/if}
                     {if isset($thingy.strings.esrbarating)}
                      <div class="serendipity_amazonchr_attr" id="amazonchr_esrbarating">{$CONST.PLUGIN_EVENT_AMAZONCHOOSER_ESRBAGERATING}: {$thingy.strings.esrbarating}</div>
                     {/if}
                     {if isset($thingy.strings.audiencerating)}
                      <div class="serendipity_amazonchr_attr" id="amazonchr_audiencerating">{$CONST.PLUGIN_EVENT_AMAZONCHOOSER_AUDIENCERATING}: {$thingy.strings.audiencerating}</div>
                     {/if}
                     {if isset($thingy.strings.ISBN)}
                      <div class="serendipity_amazonchr_attr" id="amazonchr_ISBN">{$CONST.PLUGIN_EVENT_AMAZONCHOOSER_ISBN}: {$thingy.strings.ISBN}</div>
                     {/if}
                     {if isset($thingy.strings.EAN)}
                      <div class="serendipity_amazonchr_attr" id="amazonchr_EAN">{$CONST.PLUGIN_EVENT_AMAZONCHOOSER_EAN}: {$thingy.strings.EAN}</div>
                     {/if}
                     {if isset($thingy.strings.price)}
                      <div class="serendipity_amazonchr_attr" id="amazonchr_price">{$CONST.PLUGIN_EVENT_AMAZONCHOOSER_PRICE}: {$thingy.strings.price}</div>
                     {/if}
                     {if isset($thingy.strings.feature)}
                      <div class="serendipity_amazonchr_attr" id="amazonchr_feature">{$CONST.PLUGIN_EVENT_AMAZONCHOOSER_FEATURE}: {$thingy.strings.feature}</div>
                     {/if}
                     <div class="serendipity_amazonchr_offers">
                         {if isset($thingy.strings.offersurl)}
                            <div class="serendipity_amazonchr_offer"><a href="{$thingy.strings.offersurl}" target="_new">{$CONST.PLUGIN_EVENT_AMAZONCHOOSER_ALLOFFERS}</a></div>
                         {/if}
                         {if isset($thingy.strings.newoffers)}
                           <div class="serendipity_amazonchr_offers" id="amazonchr_newoffers">{$thingy.strings.newoffers}</div>
                         {/if}
                         {if isset($thingy.strings.usedoffers)}
                           <div class="serendipity_amazonchr_offers" id="amazonchr_usedoffers">{$thingy.strings.usedoffers}</div>
                         {/if}
                         {if isset($thingy.strings.collectableoffers)}
                           <div class="serendipity_amazonchr_offers" id="amazonchr_collectableoffers">{$thingy.strings.collectableoffers}</div>
                         {/if}
                         {if isset($thingy.strings.refurboffers)}
                           <div class="serendipity_amazonchr_offers" id="amazonchr_refurboffers">{$thingy.strings.refurboffers}</div>
                         {/if}
                     </div>
                    </div>
                    <div class="serendipity_amazonchr_cache">{$CONST.PLUGIN_EVENT_AMAZONCHOOSER_ASOF} {$plugin_amazonchooser_cache_time}</div>
                  </div>
